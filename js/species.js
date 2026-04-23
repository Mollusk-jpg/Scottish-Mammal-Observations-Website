// This is for sort by date:
function filterTable() {
    let inputStart = document.getElementById("dateFilterStart").value;
    let inputEnd = document.getElementById("dateFilterEnd").value;
    let table = document.getElementById("tableBody");
    let rows = table.getElementsByTagName("tr");
    
    for (let i = 0; i < rows.length; i++) {
        let dateCell = rows[i].getElementsByTagName("td")[4];

        if (dateCell) {
            let dateValue = dateCell.textContent || dateCell.innerText;
            if(dateValue < inputStart){
                rows[i].style.display = dateValue === inputStart ? "" : "none";
            }
            if (dateValue > inputEnd){
                rows[i].style.display = dateValue === inputEnd ? "" : "none";
            }
                
        }
    }
}
// This is for pagination:
    