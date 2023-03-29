
jQuery(function(){
    var urlQueryString = document.location.search;
    var replaceQueryString = "";
    if (urlQueryString !== "") {
        var replace = urlQueryString.replace('login=true','');
    }
	console.log( replace );
    history.pushState(null,null,replace);
});