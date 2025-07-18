 <ul class="nav nav-underline justify-content-center">
     <li class="nav-item">
         <a class="nav-link {{ request()->is('advertiser/banner_ad') ? 'active' : '' }}"
             href="{{ url('/advertiser/banner_ad') }}" style="color: var(--themeSecondaryTxtColor);">Banner Ads</a>
     </li>
     <li class="nav-item">
         <a class="nav-link {{ request()->is('advertiser/overlay_ad') ? 'active' : '' }}"
             href="{{ url('/advertiser/overlay_ad') }}" style="color: var(--themeSecondaryTxtColor);">Overlay Ads</a>
     </li>
     <li class="nav-item">
         <a class="nav-link {{ request()->is('advertiser/video_ad') ? 'active' : '' }}"
             href="{{ url('/advertiser/video_ad') }}" style="color: var(--themeSecondaryTxtColor);">Video Ads</a>
     </li>
 </ul>
