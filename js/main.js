function displayModal(sel) {
  var row = document.getElementById('myTable').rows.namedItem("ticket_" + sel);

  document.getElementById('ticket_id').innerHTML = row.cells[0].innerHTML;
  document.getElementById('netid').innerHTML = row.cells[1].innerHTML;
  document.getElementById('date').innerHTML = row.cells[6].innerHTML;
  document.getElementById('status').innerHTML = row.cells[5].innerHTML;
  document.getElementById('message').innerHTML = row.cells[2].innerHTML;
  document.getElementById('ticket').setAttribute('value', row.cells[0].innerHTML);

}
