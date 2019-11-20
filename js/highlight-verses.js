(function() {
  if (location.hash == "") // RETURN "#NUMBER" ANCHOR
  {
    let verseNumber = location.hash.match(/\d+/)[0];
    console.log(verseNumber);
    
    document.getElementById(verseNumber).classList.add('active');
  }
})();