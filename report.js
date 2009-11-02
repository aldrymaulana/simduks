<script type="text/javascript" src="statics/js/jquery.swfobject.1-0-7.js"></script>
<script type="text/javascript">

$(document).ready(function() {
    $("#chart").flash({
        swf : "open-flash-chart.swf",
        width: 300,
        height: 200,
        flashvars: { "data-file": "data-chart.php"}
    },
    {version: 9});
});

</script>