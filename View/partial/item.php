<td>
    <div class="myCell">
        <label for="myHiddenButton<?=$params["item_id"]?>">
            <span>
                    Name: <?=$params["name"]?><br />
                    Buff: <?=$params["buff"]?><br />
                    Type: <?=$params["type"]?><br />
                    Price: <?=$params["price"]?>
            </span>
            <input class="hidden" id="myHiddenButton<?=$params["item_id"]?>" type="radio" name="item" value="<?=$params["item_id"]?>">
            <img src="<?=$params["item_icon_path"]?>" alt="Select Item">
        </label>
    </div>
</td>