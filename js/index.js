document.addEventListener('DOMContentLoaded', () => {
    const radioButtons = document.querySelectorAll('input[name="property_status"]');
    const sale_dashboard = document.getElementById('sale-dashboard');
    const rent_dashboard = document.getElementById('rent-dashboard');

    function updateActiveLabel() {
        radioButtons.forEach(radio => {
            const label = radio.closest('.status-option');
            if (!label) return;
            if (radio.checked) label.classList.add('active');
            else label.classList.remove('active');
        });
    }

    function changeInfo() {
        const checkedRadio = document.querySelector('input[name="property_status"]:checked');
        if (checkedRadio) {
            if (checkedRadio.value === 'rent') {
                rent_dashboard.style.display = 'block';
                sale_dashboard.style.display = 'none';
            } else if (checkedRadio.value === 'sale') {
                rent_dashboard.style.display = 'none';
                sale_dashboard.style.display = 'block';
            }
        } else {
            rent_dashboard.style.display = 'none';
            sale_dashboard.style.display = 'none';
        }
        updateActiveLabel();
    }

    // initialize
    changeInfo();

    radioButtons.forEach(radio => {
        radio.addEventListener('change', changeInfo);
        const label = radio.closest('.status-option');
        if (label) label.addEventListener('click', () => setTimeout(changeInfo, 10));
    });

    // Filter UI and functionality
    const filterBtn = document.querySelector('.filter-btn');
    const filterGroup = document.querySelector('.filter-group');
    const sortBy = document.getElementById('sort_by');
    const sortOrder = document.getElementById('sort_order');

    function getVisibleTable() {
        const saleTable = sale_dashboard.querySelector('table');
        const rentTable = rent_dashboard.querySelector('table');
        if (sale_dashboard.style.display !== 'none' && saleTable) return saleTable;
        if (rent_dashboard.style.display !== 'none' && rentTable) return rentTable;
        // fallback: if any table exists in DOM, return the first
        return document.querySelector('#sale-dashboard table, #rent-dashboard table');
    }

    function sortTable(table, colIndex, order = 'asc') {
        if (!table) return;
        const tbody = table.tBodies[0];
        if (!tbody) return;
        const rows = Array.from(tbody.querySelectorAll('tr'));

        rows.sort((a, b) => {
            const aText = a.children[colIndex] ? a.children[colIndex].innerText.trim() : '';
            const bText = b.children[colIndex] ? b.children[colIndex].innerText.trim() : '';

            const aNum = parseFloat(aText.replace(/[^0-9.-]+/g, ''));
            const bNum = parseFloat(bText.replace(/[^0-9.-]+/g, ''));

            if (!isNaN(aNum) && !isNaN(bNum)) {
                return order === 'asc' ? aNum - bNum : bNum - aNum;
            }

            return order === 'asc' ? aText.localeCompare(bText, undefined, {numeric: true}) : bText.localeCompare(aText, undefined, {numeric: true});
        });

        // re-append rows
        rows.forEach(r => tbody.appendChild(r));
    }

    function applySorting() {
        const table = getVisibleTable();
        if (!table) return;
        const by = (sortBy && sortBy.value) || 'block';
        const order = (sortOrder && sortOrder.value) || 'asc';
        const colIndex = by === 'block' ? 1 : 2; // block -> column 1, lot -> column 2
        sortTable(table, colIndex, order);
    }

    if (filterBtn && filterGroup) {
        filterBtn.addEventListener('click', (e) => {
            e.preventDefault();
            filterGroup.classList.toggle('hidden');
            filterBtn.classList.toggle('active');
            if (!filterGroup.classList.contains('hidden')) {
                // when showing filters, immediately apply current sorting
                applySorting();
            }
        });
    }

    if (sortBy) sortBy.addEventListener('change', applySorting);
    if (sortOrder) sortOrder.addEventListener('change', applySorting);
});
