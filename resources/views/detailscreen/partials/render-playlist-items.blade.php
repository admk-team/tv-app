  <?php
                    
                    $dataVast3 = null;
                    foreach ($latest_items['streams'] as $arrStreamsData)
                    {
                      $poster = $arrStreamsData['stream_poster'];
                      $videoUrl = $arrStreamsData['stream_url'];
                       $quality = 'video';
                        if ($videoUrl) {
                            $isShortYouTube = preg_match('/youtu\.be\/([^?&]+)/', $videoUrl, $shortYouTubeMatches);
                            $isSingleVideo = preg_match('/[?&]v=([^&]+)/', $videoUrl , $videoMatches);
                            $isVimeo = preg_match('/vimeo\.com\/(\d+)/', $videoUrl , $vimeoMatches);
                            if ($isShortYouTube) {
                                $videoUrl = $shortYouTubeMatches[1]; // Extract only the video ID
                                $quality = 'youtube_single';
                            } elseif ($isSingleVideo) {
                                $videoUrl  = $videoMatches[1]; // Extract only the video ID
                                $quality = 'youtube_single';
                            } elseif ($isVimeo) {
                                $videoUrl = $vimeoMatches[1]; // Extract only the Vimeo ID
                                $quality = 'vimeo_single';
                            }
                        }
                      if (strpos($videoUrl, '.m3u8'))
                      {
                          $quality = "hls";
                      }

                      $adParam = "videoId=".$arrStreamsData['stream_guid'].'&title='.$arrStreamsData['stream_title'];
                      $dataVast = 'data-vast="'.url('/get-ad?'.$adParam).'"';
                      $dataVast = "data-vast='$adMacros'";
                      $dataVast3 = url('/get-ad?'.$adParam);
                      if ($isMobileBrowser == 1)
                      {
                      //  $dataVast = '';
                      }
                     ?>
  <div class="mvp-playlist-item" data-path="{{ $videoUrl }}" {!! $dataVast2 ? $dataVast2 : $dataVast !!}
      data-type="{{ Str::endsWith($videoUrl, ['.mp3', '.wav']) ? 'audio' : $quality }}" data-noapi
      data-poster="{{ $poster }}" data-thumb="{{ $poster }}" data-title="{{ $arrStreamsData['stream_title'] }}"
      data-description="{{ $arrStreamsData['stream_description'] }}">

      @if (count($arrStreamsData['subtitles'] ?? []))
          <div class="mvp-subtitles">
              @foreach ($arrStreamsData['subtitles'] ?? [] as $subtitle)
                  <div data-label="{{ $subtitle['name'] }}" data-src="{{ $subtitle['file_url'] }}"
                      @if ($loop->first) data-default @endif></div>
              @endforeach
          </div>
      @endif

  </div>
  <?php
                            }
                            ?>
