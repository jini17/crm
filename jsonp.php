<!DOCTYPE html>
<html>

<body>

<h2>Request With a Callback Function</h2>
<p>The PHP file returns a call to the function you send as a callback.</p>

<button onclick="clickButton()">Click me!</button>

<p id="demo"></p>

<script>
function clickButton() {
  var s = document.createElement("script");
  s.src = "http://aw.secondcrm.com/myservice.php?callback=myFunc";
  document.body.appendChild(s);
}

function myFunc(myObj) {
  document.getElementById("demo").innerHTML = "Name :" + myObj.name+ " Age :"+myObj.age+" Designation :"+myObj.Designation;
}
</script>

</body>
</html>
