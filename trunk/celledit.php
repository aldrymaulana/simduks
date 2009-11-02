<div>
    This example show the new Cell editing feature of jqGrid. Select some cell. <br>
    The fields date, amout and tax are editable. When select a cell you can <br>
	navigate with left, right, up and down keys. The Enter key save the content. The esc does not save the content.<br>
	Try to change the values of amount or tax and see that the total changes.<br>
	To enable cell editing you should just set cellEdit: true and ajust the colModel in appropriate way.
</div>

<table id="celltbl" class="scroll" cellpadding="0" cellspacing="0"></table>
<div id="pcelltbl" class="scroll" style="text-align:center;"></div>
<script src="celledit.js" type="text/javascript"> </script>
