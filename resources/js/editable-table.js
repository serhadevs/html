// const $tableID = $("#table");
// const $BTN = $("#export-btn");
// const $EXPORT = $("#export");
// let counter = 1;

// const newTr = `
// <tr class="hide">
// <td>
                  
// <input name='item_number[]' class='productname' id="item_number" value="" type='text' size="5" style='border:none;outline:none;background: transparent;' disabled>

// </td>
// <td>

  
//    <input name='description[]'  value="" class='des' type='text' size="10" style='border:none;outline:none;background: transparent;' disabled>d>
// </td>
// <td>
// <input name='quantity[]'  class='quantity'  value="" type='number' size="5"style='width:80px;border:none;outline:none;background: transparent;' disabled>
// </td>

// <td>
//   <select name='unit[]' class='unit' id="unit" style='width:80px; border:none;outline:none;background: transparent;' disabled>

//   @foreach ($units as $unit)
//   @if($stock->unit_of_measurement_id == $unit->id)
//   <option selected value="{{ $stock->unit_of_measurement_id }}" >{{ $stock->unit_of_measurement->name }}</option>
//   @else
//   <option name='unit[]' value="{{$unit->id}}">{{$unit->name}}</option>
//   @endif
//   @endforeach
//   </select>

// </td> 
// <td>
//   <input name='unit_cost[]'size="5" class='unitcost' min="0.00" step="0.01"  value="" type='number'style='width:80px; border:none;outline:none;background: transparent;' disabled>
// </td>
// <td>
// <input name='part_number[]' class='part_number' value="" id="part_number"   type='text' size="5" style='border:none;outline:none;background: transparent;'disabled>
// </td>


// <td>
//                 </tr>`;
// $(".table-add").on("click", "i", () => {
    
//     const $clone = $tableID
//         .find("tbody tr")
//         .last()
//         .clone(true)
//         .removeClass("hide table-line");

//     if ($tableID.find("tbody tr").length === 0) {
//         $("tbody").append(newTr);
//     }

//     $tableID.find("table").append($clone);

// });

// $tableID.on("click", ".table-remove", function () {
//     $(this).parents("tr").reset();
//     $(this).parents("tr").detach();
// });

// $tableID.on("click", ".table-up", function () {
//     const $row = $(this).parents("tr");

//     if ($row.index() === 0) {
//         return;
//     }

//     $row.prev().before($row.get(0));
// });

// $tableID.on("click", ".table-down", function () {
//     const $row = $(this).parents("tr");
//     $row.next().after($row.get(0));
// });

// // A few jQuery helpers for exporting only
// jQuery.fn.pop = [].pop;
// jQuery.fn.shift = [].shift;

// $BTN.on("click", () => {
//     const $rows = $tableID.find("tr:not(:hidden)");
//     const headers = [];
//     const data = [];

//     // Get the headers (add special header logic here)
//     $($rows.shift())
//         .find("th:not(:empty)")
//         .each(function () {
//             headers.push($(this).text().toLowerCase());
//         });

//     // Turn all existing rows into a loopable array
//     $rows.each(function () {
//         const $td = $(this).find("td");
//         counter = counter + 1;
//         const h = {};

//         // Use the headers from earlier to name our hash keys
//         headers.forEach((header, i) => {
//             h[header] = $td.eq(i).text();
//         });

//         data.push(h);
//     });

//     // Output the result
//     $EXPORT.text(JSON.stringify(data));
// });
