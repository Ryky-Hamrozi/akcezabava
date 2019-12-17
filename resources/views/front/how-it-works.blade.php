@extends('front.front-layout')

@section('title', 'Jak to funguje')

@section('content')

    <div class="new-action-page how-its-going">
        <div class="flx-w row">
            <div class="w50p">
                <h1>Jsem návštěvník</h1>
                <ul>
                    <li>Vyberte si ve vyhledávacích filtrech svůj region.</li>
                    <li>Upřesněte hledání pomocí výběru kategorie, termínu  akce, nebo klíčových slov.</li>
                    <li>Stiskněte “vyhledat” a brouzdejte akcemi dle libosti.</li>
                    <li>Pomocí tlačítka sdílejte akci se svými přáteli na facebooku či jiných sociálních sítích.</li>
                </ul>
            </div>
            <div class="w50p">
                <h2>Jsem pořadatel</h2>
                <ul>
                    <li>V záhlaví stránky stiskněte tlačítko “vložit událost”.</li>
                    <li>Vyplňte všechny údaje o vaší akci včetně místa jejího konání.</li>
                    <li>Akci můžete propojit přidáním facebookového odkazu (pokud má vytvořenou událost na facebooku). Některé údaje se vám tak předvyplní.</li>
                    <li>Stiskněte “odeslat ke schválení” a čekejte než vám administrátor akci schválí, poté se vaše akce objeví ve výpisu pod příslušnou kategorií.</li>
                </ul>
            </div>
        </div>
    </div>

@endsection