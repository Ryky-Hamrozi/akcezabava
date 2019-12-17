@extends('front.front-layout')

@section('title', 'Úvod')

@section('content')

<main class="main-section">
    <h1><strong>Objevujte</strong>, co se děje ve vašem regionu</h1>
    <p>Nehledejte složitě na facebooku, vše najdete u nás! Přehledně a na jednom místě.</p>
    <div class="full-search">
      <form action="" class="flx">
        <div class="calcw flx">
          <select name="" id="">
            <option value="0">Všechny okresy</option>
            @foreach($districts as $district)
              <option value="{{$district->id}}">{{$district->name}}</option>
            @endforeach
          </select>
          <div class="datepicker-box"><input class="datepick" type="text" placeholder="Kdykoliv" id="dp1569323369937"></div>
          <select name="" id="">
            <option value="">Všechny druhy akcí</option>
            @foreach($allCategories as $category)
              <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
          </select>
        </div>
        {{--<button class="pridat" type="button" name="rozsirene" title="Rozšířené hledání"></button>--}}
        <button class="hledat" type="submit" name="vyhledat" title="Vyhledat"></button>
      </form>
    </div>
  </main>

  <section class="recomended-for-u ds">
    <h1 class="title"><span>Vybrali jsme</span> pro vás</h1>
    
    <div class="slider flx-w arrows">
      <article>
        <a href="" class="article big">
          <figure>
            <figcaption>
              <h2>Léto fest 2017</h2>
              <div class="tag" style="background: #2d7bf0;">Sport</div>
              <p class="date"><img src="img/date.svg" alt="">31. 03. 2017 - 4. 4. 2017 10:00 - 16:00</p>
              <p class="place"><img src="img/place.svg" alt="">Skokani Olomouc Baseball Club, Lazecká, 79, 779 00, Olomouc</p>
              <div class="dsc">Opět naše jedinečná UV Color Party je spojením našich skvělých projektů do jedné ještě lepší párty a zábava jakou si zaslouží právě Olomouc.Lorem Ipsum dolor sit ame Přijď oblečen/a v bílém, dostaneš welcome drink (jak je u nás dobrým zvykem) a na to, co zažiješ v klubu v životě nezapomeneš. UV děla.</div>
            </figcaption>
            <div class="box" style="background-image:url(img/bgbig.jpg)"></div>
          </figure>
        </a>
      </article>
      <article>
        <a href="" class="article big">
          <figure>
            <figcaption>
              <h2>Léto fest 2017</h2>
              <div class="tag" style="background: #2d7bf0;">Sport</div>
              <p class="date"><img src="img/date.svg" alt="">28. 05. 2017 13:00-17:00</p>
              <p class="place"><img src="img/place.svg" alt="">Skokani Olomouc Baseball Club, Lazecká, 79, 779 00, Olomouc</p>
            </figcaption>
            <div class="box" style="background-image:url(img/bgbig.jpg)"></div>
          </figure>
        </a>
      </article>
      <article>
        <a href="" class="article big">
          <figure>
            <figcaption>
              <h2>Léto fest 2017</h2>
              <div class="tag" style="background: #2d7bf0;">Sport</div>
              <p class="date"><img src="img/date.svg" alt="">28. 05. 2017 13:00-17:00</p>
              <p class="place"><img src="img/place.svg" alt="">Skokani Olomouc Baseball Club, Lazecká, 79, 779 00, Olomouc</p>
            </figcaption>
            <div class="box" style="background-image:url(img/bgbig.jpg)"></div>
          </figure>
        </a>
      </article>
    </div>     
   
  </section>

  <section class="interested-actions ds">
    <h2 class="title"><span>Další</span> zajímavé akce</h2>
    <ul class="tabs tab-menu flx">
      <li class="{{$categoryId ? '' : 'active' }}"><a href="/">Vše</a></li>
      @foreach($categories as $category)
    <li class="{{$categoryId == $category->id  ? 'active' : '' }}"><a href="{{route('home',['category' => $category->id])}}">{{$category->name}}</a></li>  
      @endforeach
    </ul>
    <div class="tabs-content">
      <div class="tab-content open" id="all">
        <div class="flx-w row">

        @foreach($events as $event)
           @include('front.event.components.eventThumbnail',['event' => $event])
        @endforeach

          <article class="p15 w33p reklama-prc">
            <a href="" class="article">
              <div class="box" style="background-image:url(img/reklama.jpg)"></div>
            </a>
          </article>

        </div>
      </div>
      <div class="tab-content" id="gastonomie">a</div>
      <div class="tab-content" id="sport">b</div>
      <div class="tab-content" id="kultura">c</div>
      <div class="tab-content" id="volnycas">d</div>
      <div class="tab-content" id="vzdelavani">e</div>
      <div class="tab-content" id="ostatni">f</div>
      <div class="center-button"><a class="button" href="">načíst další akce</a></div>
    </div>
  </section>





@endsection