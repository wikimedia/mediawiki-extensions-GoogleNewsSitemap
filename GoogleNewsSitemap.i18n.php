<?php
/**
 * Internationalisation file for extension special page GoogleNewsSitemap
 * New version of DynamicPageList extension for use by Wikinews projects
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Amgine
 */
$messages['en'] = array(
	'googlenewssitemap' => 'Google News Sitemap',
	'googlenewssitemap-desc' => 'Outputs an Atom/RSS feed as a Google News Sitemap',
	'googlenewssitemap_categorymap' => '', # Default empty. List of categories to map to keywords. Do not translate.
	'googlenewssitemap_toomanycats' => 'Error: Too many categories!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 feed.'
);

/** Message documentation (Message documentation)
 * @author Raymond
 * @author Shirayuki
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'googlenewssitemap' => '{{doc-special|GoogleNewsSitemap|unlisted=1}}',
	'googlenewssitemap-desc' => '{{desc|name=Google News Sitemap|url=http://www.mediawiki.org/wiki/Extension:GoogleNewsSitemap}}',
	'googlenewssitemap_categorymap' => '{{notranslate}}',
	'googlenewssitemap_toomanycats' => 'Error given when maximum amount of categories specified is exceeded. Default max is 6.',
	'googlenewssitemap_feedtitle' => 'Title for the RSS/ATOM feeds produced (does not appear in sitemap XML documents).

Parameters:
* $1 - language name. e.g. "English"
* $2 - feed type (RSS or ATOM), uses full-capitalized {{msg-mw|Feed-rss}} and {{msg-mw|Feed-atom}}.
* $3 - (Unused) language code. e.g. "en"',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'googlenewssitemap' => 'Google Nuus Sitemap',
	'googlenewssitemap-desc' => 'Eksporteer \'n Atom/RSS-voer as \'n Google "News Sitemap"',
	'googlenewssitemap_toomanycats' => 'Fout: Te veel kategorieë!',
	'googlenewssitemap_feedtitle' => '$2-voer van {{SITENAME}} in $1',
);

/** Arabic (العربية)
 * @author زكريا
 */
$messages['ar'] = array(
	'googlenewssitemap' => 'خريطة موقع أخبار جوجل',
	'googlenewssitemap-desc' => 'مخرجات تغذية Atom/RSS في Google News Sitemap',
	'googlenewssitemap_toomanycats' => 'خطأ: تصنيفات كثيرة!',
	'googlenewssitemap_feedtitle' => 'تغذية $1 {{SITENAME}} $2.',
);

/** Asturian (asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'googlenewssitemap' => 'Mapa del sitiu Google Noticies',
	'googlenewssitemap-desc' => 'Xenera una canal Atom/RSS como un mapa del sitiu de Google Noticies',
	'googlenewssitemap_toomanycats' => 'Error: ¡Demasiaes categoríes!',
	'googlenewssitemap_feedtitle' => 'Canal $2 de {{SITENAME}} ($1).',
);

/** Azerbaijani (azərbaycanca)
 * @author Wertuose
 */
$messages['az'] = array(
	'googlenewssitemap_toomanycats' => 'Xəta: Kateqoriya sayı həddindən çoxdur!',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'googlenewssitemap' => 'Мапа сайту Google News',
	'googlenewssitemap-desc' => 'Выводзіць стужкі Atom/RSS у выглядзе мапы сайту Google News',
	'googlenewssitemap_toomanycats' => 'Памылка: зашмат катэгорыяў!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} стужка $2.',
);

/** Bulgarian (български)
 * @author Spiritia
 */
$messages['bg'] = array(
	'googlenewssitemap_toomanycats' => 'Грешка: Твърде много категории!',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'googlenewssitemap' => 'গুগল নিউজ সাইটম্যাপ',
	'googlenewssitemap_toomanycats' => 'ত্রুটি: অনেক বেশি বিষয়শ্রেণী!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 ফিড।',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'googlenewssitemap' => "Steuñvenn lec'hienn Keleier Google",
	'googlenewssitemap-desc' => "Krouiñ a ra ul lanvad Atom/RSS evel steuñvenn ul lec'hienn Keleier Google",
	'googlenewssitemap_toomanycats' => 'Fazi : Re a rummadoù !',
	'googlenewssitemap_feedtitle' => 'Lanvad roadennoù $2 eus {{SITENAME}} e $1.',
);

/** Bosnian (bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'googlenewssitemap' => 'Google News mapa stranice',
	'googlenewssitemap-desc' => 'Daje izlaz atom/RSS fida kao Google News mapa stranice',
	'googlenewssitemap_toomanycats' => 'Greška: Previše kategorija!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 fid.',
);

/** Catalan (català)
 * @author Aleator
 * @author Davidpar
 * @author Paucabot
 */
$messages['ca'] = array(
	'googlenewssitemap' => 'Mapa del lloc Google News',
	'googlenewssitemap-desc' => 'Fes sortir un Atom/RSS feed com a Google News Sitemap',
	'googlenewssitemap_toomanycats' => 'Error: Massa categories!',
);

/** Czech (čeština)
 * @author Jkjk
 * @author Mormegil
 */
$messages['cs'] = array(
	'googlenewssitemap' => 'Mapa stránky pro Google News',
	'googlenewssitemap-desc' => 'Vytváří Google News Sitemap podle kanálu Atom/RSS',
	'googlenewssitemap_toomanycats' => 'Chyba: Příliš mnoho kategorií!',
	'googlenewssitemap_feedtitle' => '$2 kanál {{grammar:2sg|{{SITENAME}}}} v jazyce $1',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'googlenewssitemap' => 'Map safle Google News',
	'googlenewssitemap-desc' => 'Yn allbynnu ffrwd Atom/RSS fel map safle i Google News',
	'googlenewssitemap_toomanycats' => 'Gwall: Gormod o gategorïau!',
	'googlenewssitemap_feedtitle' => 'Ffrwd $2 ar {{SITENAME}} $1.',
);

/** Danish (dansk)
 * @author Christian List
 * @author Peter Alberti
 */
$messages['da'] = array(
	'googlenewssitemap' => 'Google News Sitemap',
	'googlenewssitemap-desc' => 'Giver en Atom/RSS nyhedsstrøm som et sitemap for Google Nyheder',
	'googlenewssitemap_toomanycats' => 'Fejl: For mange kategorier!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2-nyhedsstrøm.',
);

/** German (Deutsch)
 * @author Kghbln
 * @author McDutchie
 */
$messages['de'] = array(
	'googlenewssitemap' => 'Google News-Sitemap',
	'googlenewssitemap-desc' => 'Ermöglicht die Ausgabe von Atom/RSS-Feeds in Form einer Sitemap für Google News',
	'googlenewssitemap_toomanycats' => 'Fehler: Zu viele Kategorien!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2-Feed.',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'googlenewssitemap' => 'Sitaxeritaya Google Xeberi',
	'googlenewssitemap_toomanycats' => 'Xeta: kategoriyay zaf zêd ê!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} wariyeya $2.',
);

/** Lower Sorbian (dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'googlenewssitemap' => 'Sedłowy pśeglěd Google Nowosći',
	'googlenewssitemap-desc' => 'Wudawa kanal Atom/RSS ako sedłowy pśeglěd Google Nowosći',
	'googlenewssitemap_toomanycats' => 'Zmólka: Pśewjele kategorijow!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} kanal $2.',
);

/** Greek (Ελληνικά)
 * @author Glavkos
 * @author Περίεργος
 */
$messages['el'] = array(
	'googlenewssitemap' => 'Χάρτης Ειδήσεων της Google',
	'googlenewssitemap-desc' => 'Βγάζει το Χάρτη Ειδήσεων της Google ως Atom/RSS',
	'googlenewssitemap_toomanycats' => 'Σφάλμα: Υπερβολικά πολλές κατηγορίες!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 ροή.',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'googlenewssitemap' => 'Retmapo de Google-Aktualaĵoj',
	'googlenewssitemap-desc' => 'Generas Atom aŭ RSS retfluon kiel Retmapo de Google-Aktualaĵoj',
	'googlenewssitemap_toomanycats' => 'Eraro: Tro da kategorioj!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 abonfonto.',
);

/** Spanish (español)
 * @author Fitoschido
 * @author Translationista
 */
$messages['es'] = array(
	'googlenewssitemap' => 'Mapa del sitio Google Noticias',
	'googlenewssitemap-desc' => 'Genera una fuente Atom/RSS como un mapa de sitio de Google Noticias',
	'googlenewssitemap_toomanycats' => 'Error: ¡Demasiadas categorías!',
	'googlenewssitemap_feedtitle' => 'Fuente $2 en $1 de {{SITENAME}}.',
);

/** Estonian (eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'googlenewssitemap_toomanycats' => 'Tõrge: Liiga palju kategooriaid!',
);

/** Basque (euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'googlenewssitemap' => 'Google News Gunearen mapa',
	'googlenewssitemap-desc' => 'Atom/RSS iturria zehazten du Google News Gunearen maparentzat',
	'googlenewssitemap_toomanycats' => 'Errorea: Kategoria gehiegi!',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'googlenewssitemap' => 'نقشه تارنمای اخبار گوگل',
	'googlenewssitemap-desc' => 'خوراک اتم/آراس‌اس همانند نقشه تارنمای اخبار گوگل خروجی می‌دهد',
	'googlenewssitemap_toomanycats' => 'خطا: تعداد رده‌ها زیاد است!',
	'googlenewssitemap_feedtitle' => 'خوراک $2 {{SITENAME}} $1.',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Crt
 * @author Olli
 */
$messages['fi'] = array(
	'googlenewssitemap' => 'Google News -sivukartta',
	'googlenewssitemap-desc' => 'Tulostaa Atom/RSS-syötteen Google-uutissivukarttana',
	'googlenewssitemap_toomanycats' => 'Virhe: Liian monta luokkaa.',
	'googlenewssitemap_feedtitle' => 'Sivuston {{SITENAME}} $2-syöte ($1)',
);

/** French (français)
 * @author Amgine
 * @author McDutchie
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'googlenewssitemap' => 'Plan du site Google News',
	'googlenewssitemap-desc' => 'Crée un flux de données Atom ou RSS ressemblant à un plan de site pour Google News',
	'googlenewssitemap_toomanycats' => 'Erreur : Trop de catégories !',
	'googlenewssitemap_feedtitle' => 'Flux de données $2 du {{SITENAME}} en $1.',
);

/** Franco-Provençal (arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'googlenewssitemap' => 'Plan du seto Google News',
	'googlenewssitemap-desc' => 'Fât un flux de balyês Atom / RSS que ressemble a un plan du seto Google News.',
	'googlenewssitemap_toomanycats' => 'Èrror : trop de catègories !',
	'googlenewssitemap_feedtitle' => 'Flux de balyês $2 du {{SITENAME}} en $1.',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'googlenewssitemap' => 'Mapa do sitio das novas do Google',
	'googlenewssitemap-desc' => 'Dá como resultado unha fonte de novas Atom/RSS como un mapa do sitio das novas do Google',
	'googlenewssitemap_toomanycats' => 'Erro: Demasiadas categorías!',
	'googlenewssitemap_feedtitle' => 'Fonte de novas $2 de {{SITENAME}} en $1.',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'googlenewssitemap' => 'Google Nejigkeite Sytenibersicht',
	'googlenewssitemap-desc' => 'Liferet e Atom/RSS-feed as Google Nejigkeite Sytenibersicht',
	'googlenewssitemap_toomanycats' => 'Fähler: z vil Kategorie!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2-Feed.',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author YaronSh
 */
$messages['he'] = array(
	'googlenewssitemap' => 'מפת אתר לפי Google News',
	'googlenewssitemap-desc' => 'יצוא הזנת Atom/RSS בתור מפת אתר ל־Google News',
	'googlenewssitemap_toomanycats' => 'שגיאה: יותר מדי קטגוריות!',
	'googlenewssitemap_feedtitle' => 'הזנת $2 מאתר {{SITENAME}} ב{{GRAMMAR:תחילית|$1}}',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 */
$messages['hi'] = array(
	'googlenewssitemap' => 'गूगल समाचार साइटमैप',
	'googlenewssitemap_toomanycats' => 'Error: बहुत ज्यादा श्रेणीयां!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 चारा ।',
);

/** Upper Sorbian (hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'googlenewssitemap' => 'Sydłowa přehlad Google Nowinki',
	'googlenewssitemap-desc' => 'Wudawa kanal Atom/RSS jako sydłowy přehlad Google Nowinki',
	'googlenewssitemap_toomanycats' => 'Zmylk: Přewjele kategorijow!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} kanal $2.',
);

/** Hungarian (magyar)
 * @author Glanthor Reviol
 * @author TK-999
 */
$messages['hu'] = array(
	'googlenewssitemap' => 'Google hírek oldaltérkép',
	'googlenewssitemap-desc' => 'Atom/RSS hírcsatornát készít Google hírek oldaltérképként',
	'googlenewssitemap_toomanycats' => 'Hiba: túl sok kategória!',
	'googlenewssitemap_feedtitle' => 'A(z) $1 {{SITENAME}} $2-hírcsatornája.',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'googlenewssitemap' => 'Sitemap de Google News',
	'googlenewssitemap-desc' => 'Converte un syndication Atom/RSS in un Sitemap de Google News',
	'googlenewssitemap_toomanycats' => 'Error: Troppo de categorias!',
	'googlenewssitemap_feedtitle' => 'Syndication $2 de {{SITENAME}} in $1.',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Iwan Novirion
 * @author Kenrick95
 */
$messages['id'] = array(
	'googlenewssitemap' => 'Petasitus Baru Google',
	'googlenewssitemap-desc' => 'Hasil dari Atom/RSS feed sebagai Petasitus Baru Google',
	'googlenewssitemap_toomanycats' => 'Kesalahan: Terlalu banyak kategori!',
	'googlenewssitemap_feedtitle' => 'Umpan $2 $1 {{SITENAME}}.',
);

/** Italian (italiano)
 * @author Beta16
 * @author F. Cosoleto
 */
$messages['it'] = array(
	'googlenewssitemap' => 'Google News Sitemap',
	'googlenewssitemap-desc' => 'Genera un feed Atom/RSS come Sitemap per Google News',
	'googlenewssitemap_toomanycats' => 'Errore: Numero di categorie eccessivo!',
	'googlenewssitemap_feedtitle' => 'Feed $2 {{SITENAME}} $1.',
);

/** Japanese (日本語)
 * @author Hosiryuhosi
 * @author Naohiro19
 * @author Ohgi
 * @author Schu
 * @author Shirayuki
 */
$messages['ja'] = array(
	'googlenewssitemap' => 'Google ニュース サイトマップ',
	'googlenewssitemap-desc' => 'Atom/RSS フィードを Google ニュース サイトマップとして出力する',
	'googlenewssitemap_toomanycats' => 'エラー: カテゴリが多すぎます!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 フィード。',
);

/** Javanese (Basa Jawa)
 * @author NoiX180
 */
$messages['jv'] = array(
	'googlenewssitemap' => 'Petasitus Warta Google',
	'googlenewssitemap-desc' => 'Asilaké lebon saran Atom/RSS minangka Petasitus Warta Google',
	'googlenewssitemap_toomanycats' => 'Kasalahan: Kakèhan katègori!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 lebon saran.',
);

/** Georgian (ქართული)
 * @author David1010
 */
$messages['ka'] = array(
	'googlenewssitemap' => 'Google News-ის ვებ-გვერდის რუკა',
	'googlenewssitemap_toomanycats' => 'შეცდომა: ძალიან ბევრი კატეგორიაა!',
);

/** Korean (한국어)
 * @author 아라
 */
$messages['ko'] = array(
	'googlenewssitemap' => 'Google 뉴스 사이트맵',
	'googlenewssitemap-desc' => 'Google 뉴스 사이트맵으로 Atom/RSS 피드를 출력합니다',
	'googlenewssitemap_toomanycats' => '오류: 분류가 너무 많습니다!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 피드입니다.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'googlenewssitemap' => '<i lang="en">Google News Sitemap</i>',
	'googlenewssitemap-desc' => 'Deiht ene <i lang="en">Atom</i> udder <i lang="en">RSS</i>-Kanaal als en <i lang="en">Google News Sitemap</i> ußjävve.',
	'googlenewssitemap_toomanycats' => 'Fähler: Zoh vill Saachjroppe!',
	'googlenewssitemap_feedtitle' => '{{ucfirst:{{GRAMMAR:Genitive iere male|{{SITENAME}}}}}} <i lang="en">$2</i> Kanaal op $1',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'googlenewssitemap' => 'Google News Plang vum Site',
	'googlenewssitemap-desc' => 'Produzéiert en Atom/RSS feed als Google News Sitemap',
	'googlenewssitemap_toomanycats' => 'Feeler: Zevill Kategorien!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2-Feed.',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'googlenewssitemap' => 'План на страницата Google Вести',
	'googlenewssitemap-desc' => 'Дава Atom/RSS канал како план на страницата Google Вести',
	'googlenewssitemap_toomanycats' => 'Грешка: Премногу категории!',
	'googlenewssitemap_feedtitle' => '$2-канал на {{SITENAME}} на $1.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'googlenewssitemap' => 'ഗൂഗിൾ ന്യൂസ് സൈറ്റ്മാപ്പ്',
	'googlenewssitemap-desc' => 'ഗൂഗിൾ ന്യൂസ് സൈറ്റ്മാപ്പ് ആറ്റം/ആർ.എസ്.എസ്. ഫീഡായി പുറത്തേയ്ക്ക് നൽകുന്നു',
	'googlenewssitemap_toomanycats' => 'പിഴവ്: വളരെയധികം വർഗ്ഗങ്ങൾ!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 ഫീഡ്.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'googlenewssitemap' => 'Google News Sitemap',
	'googlenewssitemap-desc' => 'Mengoutput suapan Atom/RSS dalam bentuk Google News Sitemap',
	'googlenewssitemap_toomanycats' => 'Ralat: Kategori terlalu banyak!',
	'googlenewssitemap_feedtitle' => 'Suapan {{SITENAME}} $1 ($2)',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'googlenewssitemap' => 'Google News Sitemap',
	'googlenewssitemap-desc' => "Toħloq ''feed'' ATOM/RSS bħala Mappa tas-sit għal Google News",
	'googlenewssitemap_toomanycats' => "Żball: Numru eċċessiv ta' kategoriji!",
	'googlenewssitemap_feedtitle' => 'Feed $2 {{SITENAME}} $1.',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'googlenewssitemap' => 'Nettstedskart for Google News',
	'googlenewssitemap-desc' => 'Gir ut en Atom/RSS-mating som et nettstedskart for Google News',
	'googlenewssitemap_toomanycats' => 'Feil: For mange kategorier!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2-mating.',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Mihxil
 * @author Siebrand
 */
$messages['nl'] = array(
	'googlenewssitemap' => 'Google Nieuws Sitemap',
	'googlenewssitemap-desc' => 'Levert een Atom/RSS-feed als Google Nieuws Sitemap',
	'googlenewssitemap_toomanycats' => 'Fout: te veel categorieën!',
	'googlenewssitemap_feedtitle' => '$2-feed van {{SITENAME}} in het $1',
);

/** Norwegian Nynorsk (norsk nynorsk)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'googlenewssitemap_toomanycats' => 'Feil: For mange kategoriar.',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'googlenewssitemap' => 'Google nòvas Sitemap',
	'googlenewssitemap-desc' => 'Crèa un Atom o RSS feed coma un plan Sitemap per Google',
	'googlenewssitemap_toomanycats' => 'Error : Tròp de categorias !',
	'googlenewssitemap_feedtitle' => 'Flux de donadas $2 del {{SITENAME}} en $1.',
);

/** Polish (polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'googlenewssitemap' => 'Mapa serwisu dla Google News',
	'googlenewssitemap-desc' => 'Treść kanałów Atom i RSS w formie mapy witryny dla Google News',
	'googlenewssitemap_toomanycats' => 'Błąd – zbyt wiele kategorii!',
	'googlenewssitemap_feedtitle' => '{{SITENAME}} ($1) – kanał $2.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'googlenewssitemap' => 'Pian dël sit dle Neuve ëd Google',
	'googlenewssitemap-desc' => 'A scriv un fluss Atom/RSS com pian dël Sit ëd le Neuve ëd Google',
	'googlenewssitemap_toomanycats' => 'Eror: Tròpe categorìe!',
	'googlenewssitemap_feedtitle' => 'Fluss $2 ëd {{SITENAME}} an $1.',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'googlenewssitemap' => 'Google News Sitemap',
	'googlenewssitemap-desc' => 'Converte um feed Atom/RSS para um Google News Sitemap',
	'googlenewssitemap_toomanycats' => 'Erro: Categorias a mais!',
	'googlenewssitemap_feedtitle' => 'Feed $2 da {{SITENAME}} em $1.',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Daemorris
 * @author Giro720
 * @author Raylton P. Sousa
 */
$messages['pt-br'] = array(
	'googlenewssitemap' => 'Mapa de Site de Notícias Google',
	'googlenewssitemap-desc' => 'Produz um alimentador Atom/RSS como um Mapa de Site de Notícias Google',
	'googlenewssitemap_toomanycats' => 'Erro: Categorias demais!',
	'googlenewssitemap_feedtitle' => 'Feed $2 da {{SITENAME}} em $1.',
);

/** Romanian (română)
 * @author Firilacroco
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'googlenewssitemap' => 'Planul site-ului Google News',
	'googlenewssitemap-desc' => 'Creează un flux Atom/RSS ca un plan al site-ului Google News',
	'googlenewssitemap_toomanycats' => 'Eroare: Prea multe categorii!',
	'googlenewssitemap_feedtitle' => 'Flux $2 pentru {{SITENAME}} în $1.',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'googlenewssitemap' => "Mappe d'u site de Google News",
	'googlenewssitemap-desc' => "Le resultate de Atom/RSS feed dalle cumme a 'na mappe de site de Google News",
	'googlenewssitemap_toomanycats' => 'Errore: Troppe categorije!',
	'googlenewssitemap_feedtitle' => '$2 feed $1 de {{SITENAME}}.',
);

/** Russian (русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'googlenewssitemap' => 'Карта сайта для Google News',
	'googlenewssitemap-desc' => 'Подготавливает канал Atom/RSS в виде карты сайта для Google News',
	'googlenewssitemap_toomanycats' => 'Ошибка. Слишком много категорий!',
	'googlenewssitemap_feedtitle' => '{{SITENAME}}. $1 $2 канал.',
);

/** Rusyn (русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'googlenewssitemap' => 'Мапа сторінкы про Google News',
	'googlenewssitemap-desc' => 'Створює Google News Sitemap подля каналу Atom/RSS',
	'googlenewssitemap_toomanycats' => 'Error: дуже много катеґорій!',
	'googlenewssitemap_feedtitle' => '{{SITENAME}}. $1 $2 канал.',
);

/** Sinhala (සිංහල)
 * @author Singhalawap
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'googlenewssitemap' => 'ගූගල් පුවත් අඩවිසිතියම',
	'googlenewssitemap_toomanycats' => 'දෝෂය: ප්‍රවර්ග ගණන ඉතා වැඩිය!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 පෝෂකය.',
);

/** Slovenian (slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'googlenewssitemap' => 'Zemljevid strani Google News',
	'googlenewssitemap-desc' => 'Izpiše vir Atom/RSS kot zemljevid strani Google News',
	'googlenewssitemap_toomanycats' => 'Napaka: Preveč kategorij!',
	'googlenewssitemap_feedtitle' => 'Vir $1 {{SITENAME}} $2.',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'googlenewssitemap' => 'Мапа странице Гугл вести',
	'googlenewssitemap_toomanycats' => 'Грешка: Превише категорија!',
	'googlenewssitemap_feedtitle' => '$2 довод на {{SITENAME}} на $1.',
);

/** Serbian (Latin script) (srpski (latinica)‎)
 */
$messages['sr-el'] = array(
	'googlenewssitemap' => 'Mapa stranice Gugl vesti',
	'googlenewssitemap_toomanycats' => 'Greška: Previše kategorija!',
	'googlenewssitemap_feedtitle' => '$2 dovod na {{SITENAME}} na $1.',
);

/** Swedish (svenska)
 * @author Fredrik
 * @author Per
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'googlenewssitemap' => 'Webbkarta för Google nyheter',
	'googlenewssitemap-desc' => 'Visar ett Atom-/RSS-flöde som en webbkarta för Google nyheter',
	'googlenewssitemap_toomanycats' => 'Fel: För många kategorier!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2-flöde.',
);

/** Tamil (தமிழ்)
 * @author Karthi.dr
 */
$messages['ta'] = array(
	'googlenewssitemap_toomanycats' => 'தவறு: மிக அதிகமான பகுப்புகள் !',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'googlenewssitemap' => 'గూగుల్ వార్తల సైటుపటం',
	'googlenewssitemap_toomanycats' => 'లోపం: మరీ ఎక్కువ వర్గాలు!',
);

/** Thai (ไทย)
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'googlenewssitemap_toomanycats' => 'เกิดความผิดพลาด: เลือกประเภทมากเกินไป!',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'googlenewssitemap' => 'Mapang Pangsityo ng Balitang Google',
	'googlenewssitemap-desc' => 'Naglalabas ng pakaing Atom/RSS bilang Mapa sa Sityo ng Balitang Google',
	'googlenewssitemap_toomanycats' => 'Mali: Napakaraming mga kategorya!',
	'googlenewssitemap_feedtitle' => '$1 na {{SITENAME}} $2 na pakain.',
);

/** Turkish (Türkçe)
 * @author Emperyan
 * @author Joseph
 * @author Tarikozket
 */
$messages['tr'] = array(
	'googlenewssitemap' => 'Google Haberler Site Haritası',
	'googlenewssitemap-desc' => 'Bir Atom/RSS beslemesini Google Haberler Site haritası olarak çıktılar',
	'googlenewssitemap_toomanycats' => 'Hata: Çok fazla kategori!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 beslemesi.',
);

/** Ukrainian (українська)
 * @author Arturyatsko
 * @author Dim Grits
 */
$messages['uk'] = array(
	'googlenewssitemap' => 'Карта сайту для Google News',
	'googlenewssitemap-desc' => 'Виводить канал Atom/RSS у вигляді карти сайту для Google News',
	'googlenewssitemap_toomanycats' => 'Помилка: Надто багато категорій!',
	'googlenewssitemap_feedtitle' => '{{SITENAME}}. $1 $2 канал.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'googlenewssitemap' => 'Sơ đồ trang cho Google Tin tức',
	'googlenewssitemap-desc' => 'Cung cấp nguồn cấp Atom/RSS như mọt Sơ đồ trang Web dành cho Google Tin tức',
	'googlenewssitemap_toomanycats' => 'Lỗi: Quá nhiều thể loại!',
	'googlenewssitemap_feedtitle' => 'Nguồn cấp $2 của {{SITENAME}} $1',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'googlenewssitemap' => 'Google News Sitemap',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Gaoxuewei
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'googlenewssitemap' => 'Google 资讯站点地图',
	'googlenewssitemap-desc' => '输出一个Google 资讯站点地图的Atom/RSS文件',
	'googlenewssitemap_toomanycats' => '错误：分类过多！',
	'googlenewssitemap_feedtitle' => '$1{{SITENAME}}的$2消息来源。',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Anakmalaysia
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'googlenewssitemap' => 'Google 資訊站點地圖',
	'googlenewssitemap-desc' => '輸出一個 Google 資訊站點地圖的 Atom/RSS 文件',
	'googlenewssitemap_toomanycats' => '錯誤：分類過多！',
	'googlenewssitemap_feedtitle' => '$1{{SITENAME}}的$2消息來源。',
);
