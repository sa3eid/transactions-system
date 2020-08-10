<!-- outcome statistics part -->
<div id="ostatistics-data-bydate" class="col-sm-6">

</div>
<div id="ostatistics-data-bycategory" class="col-sm-6">

</div>
<!-- <div id="ostotal"></div> -->

<!-- outcome statistics part -->


<script>
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'ostatistics-data-bydate',
            type: 'column',
        },
        title: {
            text: "<?= $this->lang->line('Outcome amounts with respect to date') ?>"
        },
        xAxis: {
            title: {
                text: "<?= $this->lang->line('Date') ?>"
            },
            categories: [<?php echo join(',', $filtered_dates) ?>],
        },
        yAxis: {
            title: {
                text: "<?= $this->lang->line('Amount') ?>"
            }
        },
        series: [{
            name: "",
            data: [<?php echo join(',', $filtered_data) ?>],
        }]
    });

    var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'ostatistics-data-bycategory',
            type: 'pie',
        },
        title: {
            text: "<?= $this->lang->line('Outcome amounts with respect to categories') ?>"
        },
        xAxis: {

            categories: [<?php echo join(',', $filtered_cats) ?>],
        },
        yAxis: {
            title: {
                text: 'Amounts'
            }
        },
        series: [{
            name: "",
            data: [<?php echo join(',', $filtered_cats) ?>],
        }]
    });
</script>