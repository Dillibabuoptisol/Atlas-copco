<div class="tooltip1">
    <select data-ng-model="selectedRowsPerPage" data-ng-change="setNumerOfRecordPerPage(this)" class="form-control" data-ng-options="k as v for (k, v) in rowsPerPageOptions">
        <option value="10">10</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
    <span class="tooltiptext">{{trans(MESSAGE_NO_ITEMS_TO_SHOW)}}</span>
</div>