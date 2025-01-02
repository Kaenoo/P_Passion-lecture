var loadFile = function(event) {
  var output = document.getElementById('output');
  const defaultImage = document.getElementById('defaultImage');

  // Masquer l'image par défaut si elle existe
  if (defaultImage) {
    defaultImage.style.display = 'none';
  }

  output.src = URL.createObjectURL(event.target.files[0]);
  output.onload = function() {
    URL.revokeObjectURL(output.src) // free memory
  }
};