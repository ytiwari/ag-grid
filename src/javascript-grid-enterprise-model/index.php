<?php
$key = "Enterprise";
$pageTitle = "ag-Grid New Enterprise Model";
$pageDescription = "ag-Grid is going bringing datagrids to the next level with it's Enterprise Data Model, allowing slicing and dicing of data driven by your UI.";
$pageKeyboards = "ag-Grid Enterprise Row Model";
$pageGroup = "row_models";
include '../documentation-main/documentation_header.php';
?>

<h2 id="enterpriseRowModel">
    <img src="../images/enterprise_50.png" title="Enterprise Feature"/>
    Enterprise Row Model
</h2>

<p>
    The default row model for ag-Grid, the <b>In Memory</b> row model, will do grouping and
    aggregation for you if you give it all the data. If the data will not fit in the browser
    because it is to large, then you can use either <b>Infinite Scrolling</b> row model or
    <b>Viewport</b> row model. However these row models cannot do grouping or aggregation.
</p>

<p>
    The <b>Enterprise Row Model</b> presents the ability to have grouping and aggregation
    on large datasets by delegating the aggregation to the server and lazy loading
    the groups.
</p>

<p>
    Some users might simply see it as lazy loading group data from the server. Eg
    if you have a managers database table, you can display a list of all managers,
    then then click 'expand' on the manager and the grid will then request
    to get the 'employees' for that manager.
</p>

<p>
    Or a more advanced use case would be to allow the user to slice and dice a large
    dataset and have the backend generate SQL (or equivalent if not using a SQL
    store) to create the result. This would be similar to how current data analysis
    tools work, a mini-Business Intelligence experience.
</p>

<h3>How it Works</h3>

<p>
    You provide the grid with a datasource. The interface for the datasource is as follows:
</p>

<pre><span class="codeComment">// datasource for enterprise row model</span>
interface IEnterpriseDatasource {

    <span class="codeComment">// just one method, to get the rows</span>
    getRows(params: IEnterpriseGetRowsParams): void;
}
</pre>

<p>
    The getRows takes the following parameters:
</p>

<pre>interface IEnterpriseGetRowsParams {

    <span class="codeComment">// details for the request</span>
    request: IEnterpriseGetRowsRequest;

    <span class="codeComment">// success callback, pass the rows back the grid asked for</span>
    successCallback(rowsThisPage: any[]): void;

    <span class="codeComment">// fail callback, tell the grid the call failed so it can adjust it's state</span>
    failCallback(): void;
}
</pre>

<p>
    The request, with details about what the grid needs, has the following structure:
</p>

<pre>interface IEnterpriseGetRowsRequest {

    <span class="codeComment">// details for the request</span>
    rowGroupCols: ColumnVO[];

    <span class="codeComment">// columns that have aggregations on them</span>
    valueCols: ColumnVO[];

    <span class="codeComment">// what groups the user is viewing</span>
    groupKeys: string[];

    <span class="codeComment">// if filtering, what the filter model is</span>
    filterModel: any;

    <span class="codeComment">// if sorting, what the sort model is</span>
    sortModel: any;
}

<span class="codeComment">// we pass a VO (Value Object) of the column and not the column itself,</span>
<span class="codeComment">// so the data can be converted to JSON and passed to server side</span>
export interface ColumnVO {
    id: string;
    displayName: string;
    field: string;
    aggFunc: string;
}
</pre>

<p>
    All the interfaces above is a lot to take in. The best thing to do is look at the examples below
    and debug through them with teh web console and observed what is passed back as you interact
    with the grid.
</p>

<h3>Example - Predefined Master Detail - Mocked Server</h3>

<p>
    Below shows an example of predefined master / detail using the olympic winners.
    It is pre-defined as we set the grid with a particular grouping, and then
    our datasource knows that the grid will either be asking for the top level
    nodes OR the grid will be looking for the lower level nodes for a country.
</p>

<p>
    In your application, your server side would know where to get the data based
    on what the user is looking for, eg if using a relational database, it could go
    to the 'countries' table to get the list of countries and then the 'winners'
    table to get the details as the user expands the group.
</p>

<p>
    In the example, the work your server would do is mocked for demonstrations
    purposes (as the online examples are self contained and do not contact any
    servers).
</p>

<p>
    The example demonstrates the following:
    <ul>
        <li><b>Grouping:</b> The data is grouped by country.</li>
        <li><b>Aggregation:</b> The server always sum's gold, silver and bronze.
        The columns are not set as value columns, and hence the user cannot change
        the aggregation function. The server just assumes if grouping, then these
        </li>
        <li><b>Filtering:</b> The age, country and year columns have filters.
            The filtering is done on the server side.</li>
        <li><b>Sorting:</b> For example, sort by Athlete, then expand a group and you will
            see Athlete is sorted. The sorting is done on the server side.</li>
    </ul>
</p>

<show-complex-example example="exampleEnterpriseSimple.html"
                      sources="{
                                [
                                    { root: './', files: 'exampleEnterpriseSimple.html,exampleEnterpriseSimple.js,mockServerSimple.js' }
                                ]
                              }"
                      exampleheight="500px">
</show-complex-example>

<h3>Example - Slice and Dice - Mocked Server</h3>

<p>
    Below shows an example of slicing and dicing the olympic winners. The user
    has full control over what they aggregate over by dragging the columns to the
    group drop zone. For example, in the example below, you can remove the grouping
    on 'country' and group by 'year' instead, or you can group by both.
</p>

<p>
    For your application, your server side would need to understand the requests
    from the client. Typically this would be used in a reporting scenario, where the
    server side would build SQL (or the SQL equivalent if using a no-SQL data store)
    and run it against the data store.
</p>

<p>
    The example below mocks a data store for demonstration purposes.
</p>

<show-complex-example example="exampleEnterpriseSliceAndDice.html"
                      sources="{
                                [
                                    { root: './', files: 'exampleEnterpriseSliceAndDice.html,exampleEnterpriseSliceAndDice.js,columns.js,mockServerComplex.js' }
                                ]
                              }"
                      exampleheight="500px">
</show-complex-example>

<h3>Example - Slice and Dice - Real Server</h3>

<p>
    It is not possible to put up a full end to end example our the documentation
    website, as we cannot host servers on our website, and even if we did, you would
    not be able to run it locally. Instead we have put a full end to end example
    in Github at <a href="https://github.com/ceolter/ag-grid-enterprise-mysql-sample/">
    https://github.com/ceolter/ag-grid-enterprise-mysql-sample/</a> and you can also
    see it working on our
    <a href="https://www.youtube.com/watch?v=dRQtpULw6Hw">
        <img src="../images/YouTubeSmall.png" style="position: relative; top: -2px;"/>
        YouTube Movie
    </a>.
</p>

<p>
    The example puts all the olympic winners data into a MySQL database and creates SQL
    on the fly based on what the user is querying. This is a full end to end example of
    the type of slicing and dicing we want ag-Grid to be able to do in your enterprise
    applications.
</p>

<h3 id="selection">Example - Selection with Enterprise Row Model</h3>

<p>
    And this is how you do selection.
</p>

<p>
    If providing your own id's, the id's MUST be unique across the grid, for both
    groups and rows. You must provide your own id's to keep selection when you sort
    or filter.
</p>

<show-complex-example example="exampleEnterpriseSelection.html"
                      sources="{
                                [
                                    { root: './', files: 'exampleEnterpriseSelection.html,exampleEnterpriseSelection.js,mockServerComplex.js' }
                                ]
                              }"
                      exampleheight="500px">
</show-complex-example>

<p>
    And checkbox selection
</p>

<show-complex-example example="exampleEnterpriseCheckboxSelection.html"
                      sources="{
                                [
                                    { root: './', files: 'exampleEnterpriseCheckboxSelection.html,exampleEnterpriseCheckboxSelection.js,mockServerComplex.js' }
                                ]
                              }"
                      exampleheight="500px">
</show-complex-example>

<h3 id="api">Enterprise Model API</h3>

<p>
    The grid has the following API to allow you to interact with the enterprise cache.
</p>

<table class="table">
    <tr>
        <th>Method</th>
        <th>Description</th>
    </tr>
    <tr id="api-purge-virtual-page-cache">
        <th>purgeInfinitePageCache(route: string[])</th>
        <td><p>Purges the cache. If you pass no parameters, then the top level cache is purged. To
                purge a child cache, then pass in the string of keys to get to the child cache.
                For example, to purge the cache two levels down under 'Canada' and then '2002', pass
                in the string array ['Canada','2002']. If you purge a cache, then all row nodes
            for that cache will be reset to the closed state, and all child caches will be destroyed.</p></td>
    </tr>
    <tr id="api-get-virtual-page-state">
        <th>getInfinitePageState()</th>
        <td>
            Returns an object representing the state of the cache. This is useful for debugging and understanding
            how the cache is working.</td>
    </tr>
</table>

<p>
    Below shows the API in action. The following can be noted:
<ul>
    <li>
        Button <b>Purge Everything</b> purges the top level cache.
    </li>
    <li>
        Button <b>Purge [Canada]</b> purges the Canada cache only. To see this in action, make sure you have
        Canada expanded.
    </li>
    <li>
        Button <b>Purge [Canada,2002]</b> purges the 2002 cache under Canada only. To see this in action, make
        sure you have Canada and then 2002 expanded.
    </li>
    <li>
        Button <b>Print Block State</b> prints the state of the blocks in the cache to the console.
    </li>
</ul>
</p>

<show-complex-example example="exampleEnterpriseApi.html"
                      sources="{
                                [
                                    { root: './', files: 'exampleEnterpriseApi.html,exampleEnterpriseApi.js,columns.js,mockServerComplex.js' }
                                ]
                              }"
                      exampleheight="500px">
</show-complex-example>

<h3 id="pagination">Example - Pagination with Enterprise Row Model</h3>
<p>
    To enable pagination when using the enterprise row model, all you have to do is turning pagination on with
    <i>pagination=true</i>. Find below an example.
</p>

<show-complex-example example="exampleEnterpriseSimplePagination.html"
                      sources="{
                                [
                                    { root: './', files: 'exampleEnterpriseSimplePagination.html,exampleEnterpriseSimplePagination.js,mockServerSimple.js' }
                                ]
                              }"
                      exampleheight="500px">
</show-complex-example>

<?php include '../documentation-main/documentation_footer.php';?>
