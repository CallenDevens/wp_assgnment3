$(document).ready(function(){
    getAjaxMoviesInfo();
});
function getAjaxMoviesInfo(){
	$.ajax({
		type:"POST",
		url:"https://titan.csit.rmit.edu.au/~e54061/wp/movie-service.php",
		success:function(json){
			var  mainDiv=document.createElement("div");
			mainDiv.id="main";
			var contents="<h1 class='text'>-Sliver Picks: May-</h1>";
			$.each(json, function(i,film){
			    contents+="<div class='moviesMeta'><img class=\"poster_little\" src=\""+film.poster+"\" alt=\""+film.title+"\"  />";
				contents+="<h2>"+film.title+"</h2><button class='details' onclick=\"location.href='movie_session.php?title="+film.title+"' \"></button>";
				contents+="<p>"+film.summary+"</p>";
                contents+="</div>";			
			});
			mainDiv.innerHTML=contents;
            $(mainDiv).insertBefore("#footer");	
		},
		dataType:"json"
	});
}