window.addEventListener("load", function () {
  // store tabs variables
  var tabs = document.querySelectorAll("ul.nav-tabs > li");

  for (var i = 0; i < tabs.length; i++) {
    tabs[i].addEventListener("click", switchTab);
  }

  function switchTab(event) {
    event.preventDefault();

    document.querySelector("ul.nav-tabs li.active").classList.remove("active");
    document.querySelector(".tab-pane.active").classList.remove("active");

    var clickedTab = event.currentTarget;
    var anchor = event.target;
    var activePaneID = anchor.getAttribute("href");

    clickedTab.classList.add("active");
    document.querySelector(activePaneID).classList.add("active");
  }

  const spans = document.querySelectorAll(".word span");

  spans.forEach((span, idx) => {
    span.addEventListener("click", (e) => {
      e.target.classList.add("active");
    });
    span.addEventListener("animationend", (e) => {
      e.target.classList.remove("active");
    });

    // Initial animation
    setTimeout(() => {
      span.classList.add("active");
    }, 750 * (idx + 1));
  });

  let selects = document.querySelectorAll(".js-taxonomy-selector");
  selects.forEach(function (el) {
    let url = el.dataset.url;
    el.addEventListener("change", (e) => {
      let body = {
        taxonomy: el.dataset.taxonomy,
        careerist_id: el.dataset.careerist_id,
        id: e.target.value,
        action: el.dataset.action,
        nonce: el.dataset.nonce,
      };
      let params = new URLSearchParams(body);
      fetch(url, {
        method: "POST",
        body: params,
      })
        .then((res) => res.json())
        .then((response) => {});
    });
  });
});

/* Sync btn */
document.addEventListener("DOMContentLoaded", function (e) {
  let testimonialForm = document.getElementById("careerist-sync-trigger-form");

  testimonialForm.addEventListener("submit", (e) => {
    e.preventDefault();

    // reset the form messages
    resetMessages();

    // collect all the data
    let data = {
      nonce: testimonialForm.querySelector('[name="nonce"]').value,
    };

    // validate everything
    // ajax http post request
    let url = testimonialForm.dataset.url;
    let params = new URLSearchParams(new FormData(testimonialForm));

    testimonialForm.querySelector(".js-form-submission").classList.add("show");

    fetch(url, {
      method: "POST",
      body: params,
    })
      .then((res) => res.json())
      .catch((error) => {
        resetMessages();
        testimonialForm.querySelector(".js-form-error").classList.add("show");
      })
      .then((response) => {
        resetMessages();

        if (response === 0 || response.status === "error") {
          testimonialForm.querySelector(".js-form-error").classList.add("show");
          return;
        }

        testimonialForm.querySelector(".js-form-success").classList.add("show");
        testimonialForm.reset();
      });
  });

  //wp_ajax_careerist_wire_taxonomy
});

function resetMessages() {
  document
    .querySelectorAll(".field-msg")
    .forEach((f) => f.classList.remove("show"));
}

function validateEmail(email) {
  let re =
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

function format(d) {
  // `d` is the original data object for the row
  var str = "";
  str +=
    '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
  for (var attr in d) {
    if (attr.slice(0, 4) == "adam") {
      str +=
        "<tr>" +
        "<td>" +
        attr.replace("adam_", "") +
        ":</td>" +
        "<td>" +
        d[attr] +
        "</td>" +
        "</tr>";
    }
  }
  str += "</table>";
  return str;
}

function formatLogEvents(d) {
  // `d` is the original data object for the row
  var str = "";
  str +=
    '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
  str +=
    '<thead><td>Action</td><td>Adam ID</td><td>Post</td><td>Post ID</td></thead>';
  str += '<tbody>';
  for (var event of d.events) {
    let adam_id_value = ''
    let post_value = ''
    let post_id_value = ''
    switch(event.type) {
      case 'ADD_JOB':
      case 'UPDATE_JOB':
      case 'MOVE_JOB_TO_TRASH':
        adam_id_value = event.adam_id
        post_value = '<a href="/careers/position-' + event.adam_id + '" target="_blank">'+event.post_title+'</a>';
        post_id_value = event.post_id
        break;
      default:
        break;
    }
      str +=
        "<tr>" +
        "<td>" +
        event.type +
        ":</td>" +
        "<td>" +
        adam_id_value +
        "</td>" +
        "<td>" +
        post_value +
        "</td>" +
        "<td>" +
        post_id_value +
        "</td>" +
        "</tr>";
  }
  str += '</tbody>';
  str += "</table>";
  return str;
}

// TABLES START
var tables = {
  table1: {},
  table2: {},
  table3: {},
};
var drawCallback = function (table, id, formatCallback) {
  return function (settings, json) {
    let togglers = document.querySelectorAll("#" + id + " td.dt-control");
    for (let i = 0; i < togglers.length; i++) {
      togglers[i].addEventListener("click", function (evt) {
        if (!table) return;
        var tr = evt.target.parentNode;
        var row = table.row(tr);

        // row.child(format(tr.data('child-name'), tr.data('child-value'))).show();
        if (row.child.isShown()) {
          // This row is already open - close it
          row.child.hide();
          tr.classList.remove("shown");
        } else {
          // Open this row
          row.child(formatCallback(row.data())).show();
          tr.classList.add("shown");
        }
      });
    }
  };
};

window.addEventListener("load", function () {
  var tabs = document.querySelectorAll(".tabs ul > li");
  for (var i = 0; i < tabs.length; i++) {
    tabs[i].addEventListener("click", (e) => {
      renderTables();
    });
  }
});
function renderTable1() {
  var jobsTable = document.getElementById("myTable");
  if (jobsTable) {
    tables.table1 = Object.assign(
      tables.table1,
      new DataTable("#myTable", {
        ajax: jobsTable.dataset.fetchUrl,
        scrollY: 700,
        deferRender: true,
        scroller: true,
        columns: [
          {
            className: "dt-control",
            orderable: false,
            data: null,
            defaultContent: "",
          },
          { data: "adam_id" },
          { data: "name" },
          { data: "category" },
          { data: "subcategory" },
          { data: "post" },
        ],
        order: [[1, "desc"]],
        drawCallback: drawCallback(tables.table1, "myTable", format),
      })
    );
  }
}

function renderTable2() {
  var jobstable2 = document.getElementById("myTable2");
  if (jobstable2) {
    tables.table2 = Object.assign(
      tables.table2,
      new DataTable("#myTable2", {
        ajax: jobstable2.dataset.fetchUrl,
        scrollY: 700,
        deferRender: true,
        scroller: true,
        columns: [
          {
            className: "dt-control",
            orderable: false,
            data: null,
            defaultContent: "",
          },
          { data: "adam_id" },
          { data: "adam_description" },
          { data: "adam_ProffesionID" },
          { data: "adam_SubProffesionID" },
        ],
        order: [[1, "desc"]],
        drawCallback: (() => drawCallback(tables.table2, "myTable2", format))(),
      })
    );
  }
}

// function renderTable3() {
//   var jobstable3 = document.getElementById("myTable3");
//   if (jobstable3) {
//     tables.table3 = Object.assign(
//       tables.table3,
//       new DataTable("#myTable3", {
//         ajax: jobstable3.dataset.fetchUrl,
//         scrollY: 700,
//         deferRender: true,
//         scroller: true,
//         columns: [
//           {
//             className: "dt-control",
//             orderable: false,
//             data: null,
//             defaultContent: "",
//           },
//           { data: "timestamp" },
//           { data: "is_in_force_mode" },
//           { data: "status" },
//         ],
//         order: [[1, "desc"]],
//         drawCallback: (() => drawCallback(tables.table3, "myTable3"))(),
//       })
//     );
//   }
// }
function renderTable3() {
  var jobstable3 = document.getElementById("myTable3");
  if (jobstable3) {
    tables.table3 = Object.assign(
      tables.table3,
      new DataTable("#myTable3", {
        ajax: jobstable3.dataset.fetchUrl,
        scrollY: 700,
        deferRender: true,
        scroller: true,
        columns: [
          {
            className: "dt-control",
            orderable: false,
            data: null,
            defaultContent: "",
          },
          { data: "start_timestamp" },
          { data: "end_timestamp" },
          { data: "is_in_force_mode" },
          { data: "status" },
          { data: "events",
            render: "[, ].adam_id",
            className: "is-hidden",
            // "render": function ( data, type, row, meta ) {
            //     return '<a href="'+data+'">Download</a>';
            //   }
          },
          // { data: function(row, type, set, meta) {
          //   console.log(row, type, set, meat)
          //   // return ''
          //   // return row.events.reduce(function (curr, prev) {
          //   //   curr += prev.adam_id + ' '
          //   // }, '')
          //   },
          //   className: 'is-hidden',
          //   orderable: false,
          //   defaultContent: '',
          // },
        ],
        order: [[1, "desc"]],
        drawCallback: (() => drawCallback(tables.table3, "myTable3", formatLogEvents))(),
      })
    );
  }
}

function renderTables() {
  if (tables.table1 && tables.table1.destroy) tables.table1.destroy();
  renderTable1();
  if (tables.table2 && tables.table2.destroy) tables.table2.destroy();
  renderTable2();
  if (tables.table3 && tables.table3.destroy) tables.table3.destroy();
  renderTable3();
}

document.addEventListener("DOMContentLoaded", function () {
  renderTables();
});
// TABLES END
