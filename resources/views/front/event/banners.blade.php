@foreach($actionBanner as $banner)
    <article class="p15 w33p reklama-prc">
        <a href="{{$banner->url}}" target="_blank" class="article">
            @if($banner->getImagePath())
                <?php
                $actionBannerPath = "";
                $actionBannerPath = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
                        \App\Model\ImageGenerator::CONF_BANNER_HOMEPAGE_ACTION,
                        $banner->id,
                        $banner->getImagePath()
                );
                ?>
                <div class="box" style="background-image:url({{asset($actionBannerPath)}}})"></div>
            @endif
        </a>
    </article>
@endforeach