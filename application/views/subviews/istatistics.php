<div id="istatistics-data-bydate" class="col-sm-6">

</div>
<!-- <div id="istotal"></div> -->

<div id="istatistics-data-bycategory" class="col-sm-6">

</div>

<!-- income statistics part -->

<script>
    //statistics data by date (bar chart)
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'istatistics-data-bydate',
            type: 'column',
        },
        title: {
            text: "<?= $this->lang->line('Income amounts with respect to date') ?>",
        },
        xAxis: {
            title: {
                text: "<?= $this->lang->line('Date') ?>",
            },
            categories: [<?php echo join(',', $filtered_dates) ?>],
        },
        yAxis: {
            title: {
                text: "<?= $this->lang->line('Amount') ?>",
            }
        },
        series: [{
            name: "",
            data: [<?php echo join(',', $filtered_data) ?>],
        }]
    });

    //statistics data by category (pie chart)
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'istatistics-data-bycategory',
            type: 'pie',
        },
        title: {
            text: "<?= $this->lang->line('Income amounts with respect to categories') ?>"
        },
        xAxis: {
            categories: [<?php echo join(',', $filtered_cats) ?>],
        },
        yAxis: {
            title: {
                text: "<?= $this->lang->line('Amount') ?>",
            }
        },
        series: [{
            name: "",
            data: [<?php echo join(',', $filtered_cats) ?>],
        }]
    });
</script>