
// -------------------------------------------
// CLASSES
// -------------------------------------------

function App (siteUrl) {
  this.siteUrl = siteUrl;
  this.zoom;
  this.filterBy;
  this.filterValue;

  this.zoomTo = function (z) { 
    this.clearFilter();
    this.zoom = z;
    $(document.body).removeClass("zoom-level-1")
      .removeClass("zoom-level-2")
      .removeClass("zoom-level-3");
    $(document.body).addClass("zoom-level-"+ z);

    if (this.zoom < 3) {
      this.resizeTextsToFit();
    }
  }

  this.zoomIn = function () { 
    if (this.zoom < 3) {
      this.zoomTo(this.zoom + 1);
    }
  }

  this.zoomOut = function () { 
    if (this.zoom > 1) {
      this.zoomTo(this.zoom - 1);
    }
  }

  this.filter = function (by, value) {
    if (this.filterBy == by && this.filterValue == value) {
      this.clearFilter();
      console.log("FILTER CLEARED");
    } else {
      this.filterBy = by;
      this.filterValue = value;
      var filteredEntries = $(".entry[data-"+ by +"*='"+ value +"']");
      $(".entry").addClass("hide");
      filteredEntries.removeClass("hide");
      $(".meta-link").removeClass("selected");
      $(".meta-link[data-filter-by='"+ by +"'][data-"+ by +"='"+ value +"']").addClass("selected");
      $("body").addClass("filtered");
      $("#filter-alert #message")
        .text("Filter: "+ value +" ("+ filteredEntries.length +" "+ (filteredEntries.length == 1 ? "entry" : "entries") +")");
      console.log("FILTERED BY "+ by +" ("+ value +")");
    }
  }

  this.clearFilter = function () {
    this.filterBy = undefined;
    this.filterValue = undefined;
    $(".entry").removeClass("hide");
    $(".meta-link").removeClass("selected");
    $("body").removeClass("filtered");
  }

  /**
   * id (parent/uid)
   */
  this.openDetail = function (id) {
    $("#detail-content").empty();
    // $("#detail-content").load(this.siteUrl +"/database/"+ id, null, function () {
    $("#detail-content").load(this.siteUrl +"/"+ id, null, function () {
      $("body").addClass("detail-open");
    });
  }

  this.closeDetail = function () {
    $("body").removeClass("detail-open");
  }

  // SIMPLE
  // this.resizeTextsToFit = function () {
  //   var size = 11; // min
  //   var max = Math.round($(window).width() / 25); // max
  //   $(".entry").css("font-size", size);
  //   while ($(".entries").height()+50 < $(window).height()) {
      
  //     size++;
  //     $(".entry").css("font-size", size);

  //     console.log("w: "+ $(window).height(), size, $(".entries").height());
  //   }
  //   if (a.zoom == 1) { size--; }
  //   if (a.zoom == 2) { size = size * 2; if (size > max) { size = max; } }
  //   $(".entry").css("font-size", size);
  //   console.log(size);
  // }

  this.resizeTextsToFit = function () {
    var size = 12; // min
    var max = Math.round($(window).width() / 25); // max
    
    $(".entry .zoom-1-2 .byline").css("display", "inline");

    $(".entry").css("font-size", size);
    // if ($(".entries").height()+60 > $(window).height()) {
    //   $(".entry .zoom-1-2 .byline").css("display", "none");
    // }

    while ($(".entries").height()+80 < $(window).height()) {
      
      size++;
      $(".entry").css("font-size", size);

      console.log("w: "+ $(window).height(), size, $(".entries").height());
    }
    if (a.zoom == 1) { size--; }
    if (a.zoom == 2) { size = size * 2; if (size > max) { size = max; } }
    $(".entry").css("font-size", size);
    console.log(size);
  }
}

// -------------------------------------------
// FUNCTIONS
// -------------------------------------------


// --- Page Search

function filterTable (target, type) {
  var isActive = $(target).hasClass("active");
  var filteredEntries;
  if (!isActive) {
    filteredEntries = $("div.search-table-row[data-type='"+ type +"']");
    $("div.search-table-row").hide();
    filteredEntries.show();
    $(".entry-types a").removeClass("active");
    $(target).addClass("active");
  } else {
    filteredEntries = $("div.search-table-row");
    $("div.search-table-row").show();
    $(target).removeClass("active");
  }
  var counterText = filteredEntries.length == 1 ? "1 ENTRY" : filteredEntries.length +" ENTRIES";
  $("header .cell.counter").text(counterText);
}

// --- via https://stackoverflow.com/a/3395975
function getTextWidth (inputEl) {
  var tmp = document.createElement("span");
  tmp.className = "font-menu";
  tmp.style.whiteSpace = "pre";
  tmp.innerHTML = inputEl.value.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  document.body.appendChild(tmp);
  var theWidth = tmp.getBoundingClientRect().width;
  document.body.removeChild(tmp);
  return theWidth;
}


// -------------------------------------------
// EVENTS
// -------------------------------------------

$(".entry").mouseover(function () {
  var entities = $(this).data("entities").split(",");
  var topics = $(this).data("topics").split(",");
  var places = $(this).data("places").split(",");

  $(this).addClass("active");
  
  // V1
  // ---------------------------------------
  entities.forEach(function (e) {
    $(".entry[data-entities*='"+ e +"']").addClass("active");
  });
  // topics.forEach(function (e) {
  //   $(".entry[data-topics*='"+ e +"']").addClass("active");
  // });
  // places.forEach(function (e) {
  //   $(".entry[data-places*='"+ e +"']").addClass("active");
  // });
  // ---------------------------------------

  // V2
  // ---------------------------------------
  // $(".entry").addClass("redacted");
  // entities.forEach(function (e) {
  //   $(".entry[data-entities*='"+ e +"']").removeClass("redacted").addClass("active");
  // });
  // topics.forEach(function (e) {
  //   $(".entry[data-topics*='"+ e +"']").removeClass("redacted");
  // });
  // places.forEach(function (e) {
  //   $(".entry[data-places*='"+ e +"']").removeClass("redacted");
  // });
  // ---------------------------------------
  
  if (a.zoom == 3) {
    entities.forEach(function (e) {
      $(".meta-link[data-entities*='"+ e +"']").addClass("active");
    });
    topics.forEach(function (e) {
      $(".meta-link[data-topics*='"+ e +"']").addClass("active");
    });      
  }
});

$(".entry").mouseout(function () {
  $(".entry, .meta-link").removeClass("active");
  $(".entry").removeClass("redacted");
});

$(".entry, .entry-prev").click(function () {
  // var parent = $(this).data("template") == "item" ? "items" : "entities";
  // var callUrl = "<?= $site->url() ?>/"+ parent +"/"+ $(this).data("uid");
  // console.log(callUrl);

  // $("#detail-content").empty();
  
  // $("#detail-content").load(callUrl, null, function () {
  //   $("#overlay").addClass("show");
  // });

  var parent = $(this).data("template") == "item" ? "items" : "entities";
  var id = "database/"+ parent +"/"+ $(this).data("uid");
  a.openDetail(id);
});

$(".meta-link").click(function () {
  var filterBy = $(this).data("filter-by");
  var filterValue = $(this).data(filterBy);
  $(".entry").addClass("loading");

  var tempA = a;
  setTimeout(function () {
    tempA.filter(filterBy, filterValue);
    $(".entry").removeClass("loading");
  }, 500);

  $("html, body").animate({ scrollTop: 0 }, 400, function () {});
});

$("#overlay").click(function (event) {
  if (event.target == this) {
    a.closeDetail();
  }
});

$(".click-open-data-url").click(function () {
  document.location = this.dataset.url;
});

$(window).resize(function (e) {
  if (a.zoom < 3) {
    a.resizeTextsToFit();
  }
});

$("input#search-query").on('keyup', function (event) {
  var inputEl = $("input#search-query")[0];
  if (event.defaultPrevented) {
    return; 
  }
  var key = event.key || event.keyCode;
  if (key === 'Enter' || key === 13) {
    $("search-form").submit();
  } else {
    if (inputEl.value.length == 0) {
      $("#enter").removeClass("show");
    } else {
      var pl = 55 + 5 + getTextWidth(inputEl);
      $("#enter").addClass("show");
      $("#enter").css("padding-left", pl +"px");
    }
  }
}).on("blur", function () {
  $("#enter").removeClass("show");
});



// -------------------------------------------
// KEY BINDINGS
// -------------------------------------------

document.addEventListener('keyup', function (event) {
  if (event.defaultPrevented) {
    return; 
  }
  var key = event.key || event.keyCode;
  if (key === 'Escape' || key === 'Esc' || key === 27) {
    a.closeDetail();
  }
});

// -------------------------------------------
// ON READY
// -------------------------------------------

$(document).ready(function () {
  $("input#search-query").focus();
});




