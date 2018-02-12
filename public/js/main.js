
$( document ).ready(function() {

  var BookTable = function(container) {
    this.table = container,
    this.methods = {
      "ASC" : "DESC",
      "DESC" : "ASC"
    },
    this.arrows = {
      "ASC" : '&#8593;',
      "DESC": '&darr;'
    }
  }

  BookTable.prototype.renderTable = function(data) {
    var books = data.books;
    var loggedIn = data.is_logged_in;
    var table_body = ``;
    for (let prop in books) {
      let dataRow = books[prop];
      let row = `
        <tr>
          <td>${dataRow.id}</td>
          <td>${dataRow.name}</td>
          <td>${dataRow.email}</td>
          <td>${dataRow.website}</td>
          <td>${dataRow.created}</td>

          ${loggedIn ?
            `<td><a class="btn btn-primary" href="/otakoyi/book/${dataRow.id}">Update</a>
              <a href="/otakoyi/book/${dataRow.id}/delete" class="btn btn-danger" data-id="${dataRow.id}">Delete</a></td>'`
              : ''}
        </tr>
      `;
      table_body += row;
    }
    console.log(this.table.find('tbody'));
    this.table.find('tbody').html(table_body);
  }

  BookTable.prototype.setEvents = function() {
    var that = this;

    $('.order-btn').on('click', function(e) {
      e.preventDefault();

      var clickedOption = this;

      let method = this.getAttribute('data-method');
      method = that.methods[method];

      let order = this.getAttribute('data-order');
      let page = $('.pagination li.active').get(0).getAttribute('data-page');
      let url = `/otakoyi/book&type=json&order=${order}&method=${method}&page=${page}`;

      $.get( url )
        .done(function( data ) {
          data = JSON.parse(data);
          $('.order-btn.active').find('span').html(' ');
          $('.order-btn.active').removeClass('active');
          $(clickedOption).addClass('active');
          clickedOption.setAttribute('data-method', data.method);
          $(clickedOption).find('span').html(that.arrows[data.method]);
          that.renderTable(data);
        });
    });

    $('.page-btn').on('click', function(e) {
      e.preventDefault();

      var clickedOption = this;

      let page = this.getAttribute('data-page');
      let method = $('.order-btn.active').get(0).getAttribute('data-method');
      let order = $('.order-btn.active').get(0).getAttribute('data-order');

      let url = `/otakoyi/book&type=json&page=${page}&method=${method}&order=${order}`;

      $.get( url )
        .done(function( data ) {
          data = JSON.parse(data);
          $('.pagination li.active').removeClass('active');
          $(clickedOption).addClass('active');
          that.renderTable(data);
        });
    });

  }

  var table = new BookTable($('#books-table'));
  table.setEvents();


});
