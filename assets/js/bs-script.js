// Get form steps to create side menu
// Get all IDs
var stepsID = document.querySelectorAll('[id*="pat-step"]');
// For each step, get the title and add them to an array ID => title
var steps = [];
stepsID.forEach( item => {
  var title = item.querySelector('.acf-label label').textContent;
  steps[item.id] = title;
});
// For each item in the steps array, add a link to the menu
for (var k in steps){
  if (typeof steps[k] !== 'function') {
   jQuery('#acf_pat_steps').append('<li><a href="#' + k + '">' + steps[k] + '</a></li>');
  }
}
