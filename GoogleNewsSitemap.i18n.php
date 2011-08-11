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
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'googlenewssitemap-desc' => '{{desc}}',
	'googlenewssitemap_toomanycats' => 'Error given when maximum amount of categories specified is exceeded. Default max is 6.',
	'googlenewssitemap_feedtitle' => 'Title for the RSS/ATOM feeds produced (does not appear in sitemap XML documents).
*$1 is language name (like English)
*$2 is feed type (RSS or ATOM)
*$3 is language code (like en)',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'googlenewssitemap' => 'Google Nuus Sitemap',
	'googlenewssitemap-desc' => 'Eksporteer \'n Atom/RSS-voer as \'n Google "News Sitemap"',
	'googlenewssitemap_toomanycats' => 'Fout: Te veel kategorieë!',
	'googlenewssitemap_toofewcats' => 'Fout: Te min kategorieë!',
	'googlenewssitemap_noresults' => 'Fout: Geen resultate!',
	'googlenewssitemap_noincludecats' => "Fout: U moet ten minste een kategorie insluit, of spesifiseer 'n naamspasie!",
);

/** Azerbaijani (Azərbaycanca)
 * @author Wertuose
 */
$messages['az'] = array(
	'googlenewssitemap_toomanycats' => 'Xəta: Kateqoriya sayı həddindən çoxdur!',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
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

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'googlenewssitemap_noresults' => 'Грешка: Няма резултати!',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'googlenewssitemap' => 'গুগল নিউজ সাইটম্যাপ',
	'googlenewssitemap_toomanycats' => 'ত্রুটি: অনেক বেশি বিষয়শ্রেণী!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 ফিড।',
);

/** Breton (Brezhoneg)
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

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'googlenewssitemap' => 'Google News mapa stranice',
	'googlenewssitemap-desc' => 'Daje izlaz atom/RSS fida kao Google News mapa stranice',
	'googlenewssitemap_toomanycats' => 'Greška: Previše kategorija!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2 fid.',
);

/** Catalan (Català)
 * @author Aleator
 * @author Davidpar
 * @author Paucabot
 */
$messages['ca'] = array(
	'googlenewssitemap' => 'Mapa del lloc Google News',
	'googlenewssitemap-desc' => 'Fes sortir un Atom/RSS feed com a Google News Sitemap',
	'googlenewssitemap_toomanycats' => 'Error: Massa categories!',
	'googlenewssitemap_toofewcats' => 'Error: Massa poques categories!',
	'googlenewssitemap_noresults' => 'Error: Cap resultat!',
	'googlenewssitemap_noincludecats' => "Error: Heu d'incloure almenys una categoria o especificar un espai de noms!",
	'googlenewssitemap_badfeedobject' => '$feed no és un objecte.',
);

/** Czech (Česky)
 * @author Jkjk
 * @author Mormegil
 */
$messages['cs'] = array(
	'googlenewssitemap' => 'Mapa stránky pro Google News',
	'googlenewssitemap-desc' => 'Vytváří Google News Sitemap podle kanálu Atom/RSS',
	'googlenewssitemap_toomanycats' => 'Chyba: Příliš mnoho kategorií!',
	'googlenewssitemap_feedtitle' => '$2 kanál {{grammar:2sg|{{SITENAME}}}} v jazyce $1',
);

/** German (Deutsch)
 * @author Kghbln
 * @author McDutchie
 */
$messages['de'] = array(
	'googlenewssitemap' => 'Ermöglicht eine Sitemap für „Google News“',
	'googlenewssitemap-desc' => 'Gibt Atom/RSS-Feeds in Form einer Sitemap für Google News aus.',
	'googlenewssitemap_toomanycats' => 'Fehler: Zu viele Kategorien!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2-Feed.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'googlenewssitemap' => 'Sedłowy pśeglěd Google Nowosći',
	'googlenewssitemap-desc' => 'Wudawa kanal Atom/RSS ako sedłowy pśeglěd Google Nowosći',
	'googlenewssitemap_toomanycats' => 'Zmólka: Pśewjele kategorijow!',
	'googlenewssitemap_toofewcats' => 'Zmólka: Pśemało kategorijow!',
	'googlenewssitemap_noresults' => 'Zmólka: Žedne wuslědki!',
	'googlenewssitemap_noincludecats' => 'Zmólka: Musyš nanejmjenjej jadnu kategoriju zapśěgnuś abo mjenjowy rum pódaś!',
	'googlenewssitemap_badfeedobject' => '$feed njejo objekt.',
);

/** Greek (Ελληνικά)
 * @author Περίεργος
 */
$messages['el'] = array(
	'googlenewssitemap' => 'Χάρτης Ειδήσεων της Google',
	'googlenewssitemap-desc' => 'Βγάζει το Χάρτη Ειδήσεων της Google ως Atom/RSS',
	'googlenewssitemap_toomanycats' => 'Σφάλμα: Υπερβολικά πολλές κατηγορίες!',
	'googlenewssitemap_toofewcats' => 'Σφάλμα: Υπερβολικά λίγες κατηγορίες!',
	'googlenewssitemap_noresults' => 'Σφάλμα: Δεν υπάρχουν αποτελέσματα!',
	'googlenewssitemap_noincludecats' => 'Σφάλμα: Χρειάζεται να συμπεριλάβετε τουλάχιστον μια κατηγορία, ή να προσδιορίσετε μια περιοχή ονομάτων!',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'googlenewssitemap' => 'Retmapo de Google-Aktualaĵoj',
	'googlenewssitemap-desc' => 'Generas Atom aŭ RSS retfluon kiel Retmapo de Google-Aktualaĵoj',
	'googlenewssitemap_toomanycats' => 'Eraro: Tro da kategorioj!',
	'googlenewssitemap_toofewcats' => 'Eraro: Tro malmultaj da kategorioj!',
	'googlenewssitemap_noresults' => 'Eraro: Neniuj rezultoj!',
	'googlenewssitemap_noincludecats' => 'Eraro: Vi devas inkluzivi almenaŭ unu kategorio, aŭ specifigu nomspacon!',
);

/** Spanish (Español)
 * @author Translationista
 */
$messages['es'] = array(
	'googlenewssitemap' => 'Mapa del sitio Google Noticias',
	'googlenewssitemap-desc' => 'Genera una fuenteAtom/RSS como un mapa de sitio de Google Noticias',
	'googlenewssitemap_toomanycats' => 'Error: ¡Demasiadas categorías!',
	'googlenewssitemap_toofewcats' => 'Error: ¡Muy pocas categorías!',
	'googlenewssitemap_noresults' => 'Error: ¡No hay resultados!',
	'googlenewssitemap_noincludecats' => 'Error: ¡Es necesario incluir al menos una categoría o especificar un espacio de nombres!',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'googlenewssitemap' => 'Google News Gunearen mapa',
	'googlenewssitemap-desc' => 'Atom/RSS iturria zehazten du Google News Gunearen maparentzat',
	'googlenewssitemap_toomanycats' => 'Errorea: Kategoria gehiegi!',
	'googlenewssitemap_toofewcats' => 'Errorea: Kategoria gutxiegi!',
	'googlenewssitemap_noresults' => 'Errorea: Emaitzarik ez!',
	'googlenewssitemap_noincludecats' => 'Errorea: Gutxienez kategoria bat gehitu edo izen bat zehaztu behar duzu!',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'googlenewssitemap' => 'نقشه وبگاه اخبار گوگل',
	'googlenewssitemap-desc' => 'خوراک اتم/آراس‌اس همانند نقشه وبگاه اخبار گوگل خروجی می‌دهد',
	'googlenewssitemap_toomanycats' => 'خطا: تعداد رده‌ها زیاد است!',
	'googlenewssitemap_feedtitle' => 'خوراک $2 {{SITENAME}} $1.',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 */
$messages['fi'] = array(
	'googlenewssitemap' => 'Google News -sivukartta',
	'googlenewssitemap-desc' => 'Tulostaa Atom/RSS-syötteen Google-uutissivukarttana',
	'googlenewssitemap_toomanycats' => 'Virhe: Liian monta luokkaa.',
	'googlenewssitemap_toofewcats' => 'Virhe: Liian vähän luokkia.',
	'googlenewssitemap_noresults' => 'Virhe: Ei tuloksia.',
	'googlenewssitemap_noincludecats' => 'Error: Lisää vähintään yksi luokka tai määritä nimiavaruus.',
);

/** French (Français)
 * @author Amgine
 * @author McDutchie
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'googlenewssitemap' => 'Plan du site Google News',
	'googlenewssitemap-desc' => 'Crée un flux de données Atom ou RSS ressemblant à un plan de site pour Google News',
	'googlenewssitemap_toomanycats' => 'Erreur: Trop de catégories!',
	'googlenewssitemap_feedtitle' => 'Flux de données $2 du {{SITENAME}} en $1.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'googlenewssitemap' => 'Plan du seto Google News',
	'googlenewssitemap_toomanycats' => 'Èrror : trop de catègories !',
	'googlenewssitemap_feedtitle' => 'Flux de balyês $2 du {{SITENAME}} en $1.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'googlenewssitemap' => 'Mapa do sitio das novas do Google',
	'googlenewssitemap-desc' => 'Dá como resultado unha fonte de novas Atom/RSS como un mapa do sitio das novas do Google',
	'googlenewssitemap_toomanycats' => 'Erro: hai moitas categorías!',
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

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'googlenewssitemap' => 'Sydłowa přehlad Google Nowinki',
	'googlenewssitemap-desc' => 'Wudawa kanal Atom/RSS jako sydłowy přehlad Google Nowinki',
	'googlenewssitemap_toomanycats' => 'Zmylk: Přewjele kategorijow!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} kanal $2.',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'googlenewssitemap' => 'Google hírek oldaltérkép',
	'googlenewssitemap-desc' => 'Atom/RSS hírcsatornát készít Google hírek oldaltérképként',
	'googlenewssitemap_toomanycats' => 'Hiba: túl sok kategória!',
	'googlenewssitemap_toofewcats' => 'Hiba: túl kevés kategória!',
	'googlenewssitemap_noresults' => 'Hiba: nincs találat!',
	'googlenewssitemap_noincludecats' => 'Hiba: legalább egy kategóriát vagy névteret meg kell adnod!',
);

/** Interlingua (Interlingua)
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

/** Italian (Italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'googlenewssitemap_toomanycats' => 'Errore: Numero di categorie eccessivo!',
	'googlenewssitemap_toofewcats' => 'Errore: Troppe poche categorie!',
	'googlenewssitemap_noresults' => 'Errore: Nessun risultato.',
	'googlenewssitemap_noincludecats' => 'Errore: È necessario includere almeno una categoria oppure specificare un namespace!',
);

/** Japanese (日本語)
 * @author Hosiryuhosi
 * @author Naohiro19
 * @author Ohgi
 */
$messages['ja'] = array(
	'googlenewssitemap' => 'Google ニュース サイトマップ',
	'googlenewssitemap-desc' => 'Google ニュースのサイトマップからAtom/RSSフィードを出力',
	'googlenewssitemap_toomanycats' => 'エラー:　カテゴリが多すぎです!',
	'googlenewssitemap_toofewcats' => 'エラー:カテゴリが少なすぎです!',
	'googlenewssitemap_noresults' => 'エラー:結果はありません!',
	'googlenewssitemap_noincludecats' => 'エラー：少なくとも1つのカテゴリまたは名前空間を指定する必要があります!',
	'googlenewssitemap_badfeedobject' => '$feedは変更対象ではありません。',
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

/** Macedonian (Македонски)
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

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'googlenewssitemap_toomanycats' => 'Feil: For mange kategoriar.',
	'googlenewssitemap_toofewcats' => 'Feil: For få kategoriar.',
	'googlenewssitemap_noresults' => 'Feil: Ingen resultat',
	'googlenewssitemap_noincludecats' => 'Feil: Du lyt inkludera minst éin kategori eller oppgje eit namnerom.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'googlenewssitemap' => 'Nettstedskart for Google News',
	'googlenewssitemap-desc' => 'Gir ut en Atom/RSS-mating som et nettstedskart for Google News',
	'googlenewssitemap_toomanycats' => 'Feil: For mange kategorier!',
	'googlenewssitemap_feedtitle' => '$1 {{SITENAME}} $2-mating.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'googlenewssitemap' => 'Google nòvas Sitemap',
	'googlenewssitemap-desc' => 'Crèa un Atom o RSS feed coma un plan Sitemap per Google',
	'googlenewssitemap_toomanycats' => 'Error : Tròp de categorias !',
	'googlenewssitemap_toofewcats' => 'Error : Pas pro de categorias !',
	'googlenewssitemap_noresults' => 'Error : Pas cap de resultat !',
	'googlenewssitemap_noincludecats' => 'Error : Vos cal inclure almens una categoria, o especificar un espaci de noms !',
);

/** Polish (Polski)
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

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'googlenewssitemap' => 'Google News Sitemap',
	'googlenewssitemap-desc' => 'Converte um feed Atom/RSS para um Google News Sitemap',
	'googlenewssitemap_toomanycats' => 'Erro: Categorias a mais!',
	'googlenewssitemap_feedtitle' => 'Feed $2 da {{SITENAME}} em $1.',
);

/** Brazilian Portuguese (Português do Brasil)
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

/** Romanian (Română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'googlenewssitemap_toomanycats' => 'Eroare: Prea multe categorii!',
	'googlenewssitemap_toofewcats' => 'Eroare: pre',
	'googlenewssitemap_noresults' => 'Eroare: Niciun rezultat!',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'googlenewssitemap_toomanycats' => 'Errore: Troppe categorije!',
	'googlenewssitemap_feedtitle' => '$2 feed $1 de {{SITENAME}}.',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'googlenewssitemap' => 'Карта сайта для Google News',
	'googlenewssitemap-desc' => 'Подготавливает канал Atom/RSS в виде карты сайта для Google News',
	'googlenewssitemap_toomanycats' => 'Ошибка. Слишком много категорий!',
	'googlenewssitemap_feedtitle' => '{{SITENAME}}. $1 $2 канал.',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'googlenewssitemap' => 'Zemljevid strani Google News',
	'googlenewssitemap-desc' => 'Izpiše vir Atom/RSS kot zemljevid strani Google News',
	'googlenewssitemap_toomanycats' => 'Napaka: Preveč kategorij!',
	'googlenewssitemap_feedtitle' => 'Vir $1 {{SITENAME}} $2.',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'googlenewssitemap_toomanycats' => 'Грешка: Превише категорија!',
	'googlenewssitemap_toofewcats' => 'Грешка: Премало категорија!',
	'googlenewssitemap_noresults' => 'Грешка: Нема резултата!',
);

/** Serbian Latin ekavian (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'googlenewssitemap_toomanycats' => 'Greška: Previše kategorija!',
	'googlenewssitemap_toofewcats' => 'Greška: Premalo kategorija!',
	'googlenewssitemap_noresults' => 'Greška: Nema rezultata!',
);

/** Swedish (Svenska)
 * @author Fredrik
 * @author Per
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'googlenewssitemap' => 'Webbkarta för Google nyheter',
	'googlenewssitemap-desc' => 'Visar ett Atom-/RSS-flöde som en webbkarta för Google nyheter',
	'googlenewssitemap_toomanycats' => 'Fel: För många kategorier!',
	'googlenewssitemap_toofewcats' => 'Fel: För få kategorier!',
	'googlenewssitemap_noresults' => 'Fel: Inget resultat!',
	'googlenewssitemap_noincludecats' => 'Fel: Du måste inkludera minst en kategori eller specificera en namnrymd!',
	'googlenewssitemap_badfeedobject' => '$feed är inte ett objekt.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'googlenewssitemap' => 'గూగుల్ వార్తల సైటుపటం',
	'googlenewssitemap_toomanycats' => 'పొరపాటు: చాలా ఎక్కువ వర్గాలు!',
	'googlenewssitemap_toofewcats' => 'పొరపాటు: చాలా తక్కువ వర్గాలు!',
	'googlenewssitemap_noresults' => 'పొరపాటు: ఫలితాలు లేవు!',
);

/** Thai (ไทย)
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'googlenewssitemap_toomanycats' => 'เกิดความผิดพลาด: เลือกประเภทมากเกินไป!',
	'googlenewssitemap_toofewcats' => 'เกิดความผิดพลาด: เลือกประเภทน้อยเกินไป!',
	'googlenewssitemap_noresults' => 'เกิดความผิดพลาด: ไม่พบข้อมูล!',
	'googlenewssitemap_noincludecats' => 'เกิดความผิดพลาด: คุณต้องเลือกอย่างน้อยหนึ่งประเภท หรือกำหนด Namespace!',
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
 * @author Joseph
 * @author Tarikozket
 */
$messages['tr'] = array(
	'googlenewssitemap' => 'Google Haberler Site haritası',
	'googlenewssitemap-desc' => 'Bir Atom/RSS beslemesini Google Haberler Site haritası olarak çıktılar',
	'googlenewssitemap_toomanycats' => 'Hata: Çok fazla kategori!',
	'googlenewssitemap_toofewcats' => 'Hata: Çok az kategori!',
	'googlenewssitemap_noresults' => 'Hata: Sonuç yok!',
	'googlenewssitemap_noincludecats' => 'Hata: En az bir kategori girmeli, ya da bir ad alanı belirtmelisiniz!',
	'googlenewssitemap_badfeedobject' => '$feed bir nesne değil.',
);

/** Ukrainian (Українська)
 * @author Arturyatsko
 */
$messages['uk'] = array(
	'googlenewssitemap' => 'Карта сайту для Google News',
	'googlenewssitemap-desc' => 'Виводить канал Atom/RSS у вигляді карти сайту для Google News',
	'googlenewssitemap_toomanycats' => 'Помилка: Надто багато категорій!',
	'googlenewssitemap_toofewcats' => 'Помилка: Надто мало категорії!',
	'googlenewssitemap_noresults' => 'Помилка: не знайдено!',
	'googlenewssitemap_noincludecats' => 'Помилка: Ви повинні включити хоча б одну категорію, або вказати простір імен!',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'googlenewssitemap' => 'Sơ đồ trang cho Google Tin tức',
	'googlenewssitemap-desc' => 'Cung cấp nguồn tin Atom/RSS như mọt Sơ đồ trang Web dành cho Google Tin tức',
	'googlenewssitemap_toomanycats' => 'Lỗi: Quá nhiều thể loại!',
	'googlenewssitemap_feedtitle' => 'Nguồn tin $2 của {{SITENAME}} $1',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'googlenewssitemap' => 'Google 资讯站点地图',
	'googlenewssitemap-desc' => '输出一个Google 资讯站点地图的Atom/RSS文件',
	'googlenewssitemap_toomanycats' => '错误：分类过多！',
	'googlenewssitemap_feedtitle' => '$1{{SITENAME}}的$2消息来源。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'googlenewssitemap' => 'Google 資訊站點地圖',
	'googlenewssitemap-desc' => '輸出一個 Google 資訊站點地圖的 Atom/RSS 文件',
	'googlenewssitemap_toomanycats' => '錯誤：分類過多！',
	'googlenewssitemap_toofewcats' => '錯誤：分類過少！',
	'googlenewssitemap_noresults' => '錯誤：沒有結果！',
	'googlenewssitemap_noincludecats' => '錯誤：您需要包含至少一個分類，或者指定一個名稱空間！',
);

