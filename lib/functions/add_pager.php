<?
    /*
        Add Pager Function: Adds the pager form html to the page. for use with tablesorter
        Version: 14.2.22
        Cody Joyce
    */
?>
<?function pager($id = 'pager'){?>
<div id="<?= $id ?>">
    <form>
        <img src="<?= app('lib_url') ?>/scripts/tablesorter/addons/pager/icons/first.png" class="first" />
        <img src="<?= app('lib_url') ?>/scripts/tablesorter/addons/pager/icons/prev.png" class="prev" />
        <input type="text" class="pagedisplay" />
        <img src="<?= app('lib_url') ?>/scripts/tablesorter/addons/pager/icons/next.png" class="next" />
        <img src="<?= app('lib_url') ?>/scripts/tablesorter/addons/pager/icons/last.png" class="last" />
        <select class="pagesize">
            <option selected="selected" value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="50">50</option>
        </select>
    </form>
</div>
<?}?>