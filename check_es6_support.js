var supportsES6 = function(){
  try {
    new Function("(a = 0) => a");
    return true;
  }
  catch (err) {
    return false;
  }
}();
if(!supportsES6){
    setTimeout(function(){
        var msg = 'Veuillez utiliser une version récente de google chrome, firefox ou safari.'
        document.body.innerHTML = '<div class="error_browser_msg">' + msg + '</div>'
    }, 500)
}