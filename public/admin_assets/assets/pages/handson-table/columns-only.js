document.addEventListener("DOMContentLoaded", function() {
    var hot1, stretch=document.getElementById("stretch");
    hot1=new Handsontable(stretch, {
        data: Handsontable.helper.createSpreadsheetData(10, 6), colWidths: 47, rowHeaders: !0, colHeaders: !0, stretchH: "last", contextMenu: !0
    }
    );
    var hot, myData=Handsontable.helper.createSpreadsheetData(60, 100), container=document.getElementById("freezing");
    hot=new Handsontable(container, {
        data: myData, rowHeaders: !0, colHeaders: !0, fixedColumnsLeft: 2, contextMenu: !0, manualColumnFreeze: !0
    }
    )
}

);;