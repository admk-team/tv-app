 <ul class="nav nav-underline justify-content-center">
     <li class="nav-item">
         <a class="nav-link {{ request()->is('advertiser/banner_ad') ? 'active' : '' }}"
             href="{{ url('/advertiser/banner_ad') }}" style="color: var(--themePrimaryTxtColor);">Banner Ads</a>
     </li>
     <li class="nav-item">
         <a class="nav-link {{ request()->is('advertiser/overlay_ad') ? 'active' : '' }}"
             href="{{ url('/advertiser/overlay_ad') }}" style="color: var(--themePrimaryTxtColor);">Overlay Ads</a>
     </li>
     <li class="nav-item">
         <a class="nav-link {{ request()->is('advertiser/video_ad') ? 'active' : '' }}"
             href="{{ url('/advertiser/video_ad') }}" style="color: var(--themePrimaryTxtColor);">Video Ads</a>
     </li>
 </ul>
