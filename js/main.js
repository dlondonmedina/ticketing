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

function toggleNode (hnodes, snodes) {
    hnodes.forEach(function(entry) {
        document.getElementById(entry).style.display = 'none';
    });
    snodes.forEach(function(entry) {
        document.getElementById(entry).style.display = 'block';
    });

}

function publicationForm (radio) {
    switch(radio.value) {
        case 'book':
        case 'edited_collection':
            var hide = ['publication', 'edition', 'volume', 'number', 'pages'];
            var show = ['title', 'pub_date'];
            break;
        case 'edition':
            var hide = ['publication', 'volume', 'number', 'pages'];
            var show = ['title', 'edition', 'pub_date'];
            break;
        case 'articles':
        case 'poem':
        case 'story':
            var hide = ['edition'];
            var show = ['title', 'pub_date',
                        'volume', 'number', 'pages', 'publication'];
            break;
        case 'other':
            var hide = [];
            var show = ['title', 'edition', 'pub_date', 'publication', 'volume',
                        'number', 'pages'];
            break;
    }

    toggleNode(hide, show);

}
