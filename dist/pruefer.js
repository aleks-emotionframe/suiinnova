(function () {
  var z = [], ok = 0, warn = 0;
  var T = function (s) { return (s || '').replace(/\s+/g, ' ').trim(); };
  var add = function (gut, label, wert) {
    gut ? ok++ : warn++;
    z.push((gut ? '  OK   ' : '  !!   ') + label.padEnd(22) + (wert === undefined ? '' : wert));
  };

  z.push('═══ ' + location.pathname + ' ═══');

  // Titel
  var t = T(document.title);
  add(t.length > 0 && t.length <= 62 && (t.match(/SUI Innova/gi) || []).length <= 1,
      'Titel (' + t.length + ')', t);

  // Beschreibung
  var m = document.querySelector('meta[name="description"]');
  var d = T(m && m.content);
  add(d.length >= 100 && d.length <= 170, 'Beschreibung (' + d.length + ')', d.slice(0, 70) + (d.length > 70 ? '…' : ''));

  // Hauptueberschrift
  var h = document.querySelectorAll('main h1');
  add(h.length === 1, 'H1 (' + h.length + 'x)', h.length ? T(h[0].textContent).slice(0, 60) : 'FEHLT');

  // Bilder
  var imgs = [].slice.call(document.querySelectorAll('main img'));
  var mitSrcset = imgs.filter(function (i) { return i.srcset; }).length;
  var ohneAlt = imgs.filter(function (i) { return !i.hasAttribute('alt'); }).length;
  var ohneMasse = imgs.filter(function (i) { return !i.width || !i.height; }).length;
  add(imgs.length === 0 || mitSrcset > 0, 'Bilder srcset', mitSrcset + ' von ' + imgs.length);
  add(ohneAlt === 0, 'Bilder ohne alt', ohneAlt);
  add(ohneMasse === 0 || imgs.length === 0, 'ohne Breite/Hoehe', ohneMasse);

  // Gedankenstriche im sichtbaren Text
  var txt = document.querySelector('main') ? document.querySelector('main').innerText : '';
  var fuss = document.querySelector('footer') ? document.querySelector('footer').innerText : '';
  var striche = ((txt + fuss).match(/ [—–] /g) || []).length;
  add(striche === 0, 'Gedankenstriche', striche);

  // Ganze Schweiz
  var schweiz = /ganze[nr]? Schweiz/.test(txt + fuss) && !/ganze[nr]? Deutschschweiz/.test(txt + fuss);
  add(!schweiz, '"ganze Schweiz"', schweiz ? 'noch vorhanden' : 'nein');

  // Strukturierte Daten
  var ld = [].slice.call(document.querySelectorAll('script[type="application/ld+json"]'));
  var alle = [];
  ld.forEach(function (s) {
    try {
      var j = JSON.parse(s.textContent);
      alle = alle.concat(j['@graph'] || [j]);
    } catch (e) { z.push('  !!   JSON-LD kaputt'); warn++; }
  });
  var typen = alle.map(function (o) { return o['@type']; }).join(', ');
  add(alle.length > 0, 'Schema-Typen', typen || 'KEINE');

  var lb = alle.filter(function (o) { return o.areaServed; })[0];
  var gebiet = lb ? (Array.isArray(lb.areaServed)
        ? lb.areaServed.map(function (a) { return a.name; }).join(', ')
        : lb.areaServed.name) : 'fehlt';
  add(gebiet !== 'Schweiz' && gebiet !== 'fehlt', 'Einsatzgebiet', gebiet);

  var zeiten = alle.filter(function (o) { return o.openingHoursSpecification; })[0];
  add(!!zeiten, 'Oeffnungszeiten', zeiten ? zeiten.openingHoursSpecification.length + ' Bloecke' : 'fehlen');

  z.push('  ── ' + ok + ' ok, ' + warn + ' zu pruefen ──');
  console.log(z.join('\n'));
  return z.join('\n');
})();
