function displayModal (sel) {
  var row = document.getElementById('myTable').rows.namedItem('ticket_' + sel);
  document.getElementById('ticket_id').innerHTML = row.cells[0].innerHTML;
  document.getElementById('netid').innerHTML = row.cells[1].innerHTML;
  document.getElementById('date').innerHTML = row.cells[6].innerHTML;
  document.getElementById('status').innerHTML = row.cells[5].innerHTML;
  document.getElementById('message').innerHTML = row.cells[2].innerHTML;
  document.getElementById('ticket').setAttribute('value', row.cells[0].innerHTML);
}

function accordionTable () {
    var node = document.getElementById('toggle_table');
    if (node.innerHTML == 'Open Tickets') {
        node.innerHTML = 'All Tickets';
    } else {
        node.innerHTML = 'Open Tickets';
    }
}

function publicationForm (radio) {
    var standAlone = ['book', 'edited_collection', 'edition'];
    if (standAlone.indexOf(radio.value) === -1) {
        document.getElementById('publication').style.display = 'block';
    } else {
        document.getElementById('publication').style.display = 'none';
    }
}
