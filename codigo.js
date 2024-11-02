var estado = 0
function miLog(mensaje){
    document.getElementById("log").innerHTML = mensaje
}

document.querySelector("#a").addEventListener('click', function(){
	event.preventDefault();  // Prevent any default browser behavior
    event.stopPropagation(); // Stop the event from bubbling up
	
	if(estado == 0){
		let ruta = "https://jocarsa.com/go/aob/respuestas.php?respuesta="+document.getElementById('contenidoa').innerHTML
		console.log(ruta)
		fetch(ruta)
		.then(response => {
			return response.json();
		  })
		  .then(data => {
			console.log(data)
			let a = data['a']
			let b = data['b']
			document.getElementById("a").innerHTML += "<div class='porcentaje'>"+a+"%</div>"
			document.getElementById("b").innerHTML += "<div class='porcentaje'>"+b+"%</div>"
		  })
		  this.classList.add("sombra");
		  estado = 1
	  }else{
		  pregunta()
		  tds = document.querySelectorAll("td")
		  for(var i = 0;i<tds.length;i++){
			  tds[i].classList.remove("sombra");
		  }
		  estado = 0
	  }
	  
    
    
})
document.querySelector("#b").addEventListener('click', function(){
	event.preventDefault();  // Prevent any default browser behavior
    event.stopPropagation(); // Stop the event from bubbling up
	
	if(estado == 0){
		fetch("https://jocarsa.com/go/aob/respuestas.php?respuesta="+document.getElementById('contenidob').innerHTML)
		.then(response => {
			return response.json();
		  })
		  .then(data => {
			console.log(data)
			let a = data['a']
			let b = data['b']
			document.getElementById("a").innerHTML += "<div class='porcentaje'>"+a+"%</div>"
			document.getElementById("b").innerHTML += "<div class='porcentaje'>"+b+"%</div>"
		  })
		  this.classList.add("sombra");
		estado = 1 
	  }else{
		  pregunta()
		  tds = document.querySelectorAll("td")
		  for(var i = 0;i<tds.length;i++){
			  tds[i].classList.remove("sombra");
		  }
		  estado = 0
	  }
})
function pregunta(){
    fetch("https://jocarsa.com/go/aob/preguntas.php")
    .then(response => {
        return response.json();
      })
      .then(data => {
        let a = data['opciones']['A']
        let b = data['opciones']['B']
        document.getElementById("a").innerHTML = '<span class="AA">A</span><span id="contenidoa">'+a+'</span>'
        document.getElementById("b").innerHTML = '<span class="BB">B</span><span id="contenidob">'+b+'</span>'
		document.getElementById("pregunta").innerHTML = '<img src="AOB.png" id="logo">'+data['pregunta']
      })
}
pregunta()