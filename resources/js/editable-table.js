const $tableID = $("#table");
const $BTN = $("#export-btn");
const $EXPORT = $("#export");
let counter = 1;

const newTr = `
<tr class="hide">
                 <td>
                  
                  <input name='count[]' type='text' size="5" style='border:none;outline:none;background: transparent;' value='2'>
               
                </td>
                <td>
                
                  <input name='quantity[]' type='number' size="5"style='width:80px;border:none;outline:none;background: transparent;' value=''>
     
                </td>
                <td>
                  <input name='description[]' type='text' size="10" style='border:none;outline:none;background: transparent;' value=''>
                </td>
                <td>
                <input name='unit-cost'size="5" type='number'style='width:80px; border:none;outline:none;background: transparent;' value=''>
              
                </td>
                <td>
                
                  <input name='total[]' type ='number' size="5" maxlength='5'style='width:80px;border:none;outline:none;background: transparent;' value=''>
                
                </td> 
                
                </tr>`;

$(".table-add").on("click", "i", () => {
    const $clone = $tableID
        .find("tbody tr")
        .last()
        .clone(true)
        .removeClass("hide table-line");

    if ($tableID.find("tbody tr").length === 0) {
        $("tbody").append(newTr);
    }

    $tableID.find("table").append($clone);
});

$tableID.on("click", ".table-remove", function () {
    $(this).parents("tr").detach();
});

$tableID.on("click", ".table-up", function () {
    const $row = $(this).parents("tr");

    if ($row.index() === 0) {
        return;
    }

    $row.prev().before($row.get(0));
});

$tableID.on("click", ".table-down", function () {
    const $row = $(this).parents("tr");
    $row.next().after($row.get(0));
});

// A few jQuery helpers for exporting only
jQuery.fn.pop = [].pop;
jQuery.fn.shift = [].shift;

$BTN.on("click", () => {
    const $rows = $tableID.find("tr:not(:hidden)");
    const headers = [];
    const data = [];

    // Get the headers (add special header logic here)
    $($rows.shift())
        .find("th:not(:empty)")
        .each(function () {
            headers.push($(this).text().toLowerCase());
        });

    // Turn all existing rows into a loopable array
    $rows.each(function () {
        const $td = $(this).find("td");
        counter = counter + 1;
        const h = {};

        // Use the headers from earlier to name our hash keys
        headers.forEach((header, i) => {
            h[header] = $td.eq(i).text();
        });

        data.push(h);
    });

    // Output the result
    $EXPORT.text(JSON.stringify(data));
});
