function buttonAlert() {
  alert("Clicked!");
}

function changeDiv1() {
  var form01 = document.getElementById("form01");
  var color = form01.elements[0].value;
  document.getElementById("div01").setAttribute("style", "color: " + color);
}