<?php
$pageTitle = "Status Panel: Enterprise Grade Feature of our Datagrid";
$pageDescription = "ag-Grid is a feature-rich data grid supporting major JavaScript Frameworks. One such feature is Status Panel. The Status Panel appears on the bottom of the grid and shows aggregations (sum, min, max etc.) when you select a range of cells using range selection. This is similar to what happens in Excel. Version 17 is available for download now, take it for a free two month trial.";
$pageKeyboards = "ag-Grid JavaScript Grid Status Panel";
$pageGroup = "feature";
define('skipInPageNav', true);
include '../documentation-main/documentation_header.php';
?>

<h1 class="heading-enterprise">Status Panel</h1>

<p class="lead">The status panel appears below the grid and holds components that
    typically display information about the data in the grid.
    You can add your own components to the status panel in addition to choosing
    from grid provided components.
</p>

<h2>Grid Provided Status Panel Components</h2>

<p>
    The status panel components provided by the grid are as follows:
    <ul>
    <li>
        <code>agTotalRowCountComponent</code>: Provides the total row count.
    </li>
    <li>
        <code>agTotalAndFilteredRowCountComponent</code>: Provides the total and filtered row count.
    </li>
    <li>
        <code>agFilteredRowCountComponent</code>: Provides the filtered row count.
    </li>
    <li>
        <code>agSelectedRowCountComponent</code>: Provides the selected row count.
    </li>
    <li>
        <code>agAggregationComponent</code>: Provides aggregations on the selected range.
    </li>
</ul>
</p>

<h2>Configuring the Status Panel</h2>

<p>
    The status panel is configured using the <code>statusPanel</code> grid option.
    The option takes a list of components identified by component name, alignment and additionally
    component parameters.
</p>

<p>If <code>align</code> is not specified the components will default to being aligned to the right.</p>
<p><code>key</code> is useful for accessing status panel component instances - see <a href="#accessing-status-panel-comp-instances">below</a>
for more information.</p>

<p>
    The snippet below shows a status panel configured with the grid provided
    components.
</p>

<snippet>
gridOptions: {
    statusPanel: {
        components: [
            { component: 'agTotalRowCountComponent', align: 'left', key: 'totalRowComponent' },
            { component: 'agFilteredRowCountComponent, align: 'left' },
            { component: 'agSelectedRowCountComponent', align: 'center' },
            { component: 'agAggregationComponent', align: 'right' }
        ]
    }
    // ...other grid properties
}
</snippet>

<h3>Component Alignment</h3>

<p>Components can be aligned either to the <code>left</code>, in the <code>center</code> of the panel or on the
    <code>right</code> (the default). Components within these alignments will be added in the order specified.</p>

<h3>Simple Status Panel Example</h3>

<p>
    The example below shows a simply configured status panel. Note the following:
<ul>
    <li>
        The total row count is displayed by the <code>agTotalRowCountComponent</code> component, aligned to the lef1t.
    </li>
    <li>
        The row count after filtering is displayed by the <code>agFilteredRowCountComponent</code> component.
    </li>
    <li>
        The selected row count is displayed by the <code>agSelectedRowCountComponent</code> component.
    </li>
    <li>
        When a range is selected (by dragging the mouse over a range of cells) the
        <code>agAggregationComponent</code> displays the summary information
        Average, Count, Min, Max and Sum. Only Count is displayed if the range contains
        no numeric data.
    </li>
</ul>
</p>

<?= example('Status Panel Simple', 'status-panel-simple', 'generated', array("enterprise" => 1)) ?>

<h3 id="accessing-status-panel-comp-instances">Accessing Status Panel Component Instances</h3>

<p>Accessing status panel component instances is possible using <code>api.getStatusPanelComponent(key)</code>. The key will be the
value provided in the component configuration (see above), but will default to the component name if not provided.</p>

<p>See <a href="../javascript-grid-status-panel-component#accessing-status-panel-comp-instances">Accessing Status Panel
        Component Instances</a> for more information.</p>

<h2>Configuration with Component Parameters</h2>

<p>
    Some of the status panel components, or your own custom components,
    can take further parameters. These are provided using
    <code>componentParams</code>.
</p>

<p>
    The snippet below shows a status panel configured with the grid provided
    aggregation component only. The component is further configured to only
    show sum and average functions.
</p>

<snippet>
gridOptions: {
    statusPanel: {
        components: [
            {
                component: 'agAggregationComponent',
                componentParams: {
                    // possible values are: 'count', 'sum', 'min', 'max', 'avg'
                    aggFuncs: ['sum', 'avg']
                }
            }
        ]
    }
    // ...other grid properties
}
</snippet>

<h3>Example Component Parameters</h3>

<p>
    The example below demonstrates providing parameters to the status panel components.
    Note the following:
    <ul>
        <li>
            The component <code>agAggregationComponent</code> is provided with
            parameters <code>aggFuncs: ['sum', 'avg']</code>.
        </li>
        <li>
            When a range of numbers is selected, only <code>sum</code> and <code>avg</code>
            functions are displayed.
        </li>
    </ul>
</p>

<?= example('Status Panel Params', 'status-panel-params', 'generated', array("enterprise" => 1)) ?>

<h2>Status Panel Height</h2>

<p>
    The status panel sizes it's height to fit content. That means when not components are visible, the
    status panel will have zero height - it will not be shown.
</p>

<p>
    The have the status panel with a fixed height, add CSS to the status panel div as follows:
</p>

<code>
.ag-status-panel {
    min-height: 35px;
}
</code>

<h2>Aggregation Component</h2>
<p>If you have multiple ranges selected (by holding down ctrl while dragging) and a cell is in multiple
ranges, the cell will be only included once in the aggregation.</p>

<p>If the cell does not contain a simple number value, then it will not be included in average, min max or sum,
however it will still be included in count.</p>

<p>In the grid below, select a range by dragging the mouse over cells and notice the status panel
showing the aggregation values as you drag.</p>

<?= example('Status Panel', 'status-panel', 'generated', array("enterprise" => 1)) ?>

<p>By default all of the aggregations available will be displayed but you can configure the aggregation component to only
show a subset of the aggregations.</p>

<p>In this code snippet we have configured the aggregation component to only show <code>min, max and average</code>:</p>



<p>To build your own status panel component please see the section on <a href="../javascript-grid-status-panel-component">
        Status Panel Components</a>.</p>

<?php include '../documentation-main/documentation_footer.php';?>