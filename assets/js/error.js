var img = document.getElementById("myImg");
img.onerror = function () { 
    this.style.display = "none";
}