{extends file="basic.tpl"}
{block name="title"}
    Detail:{$id->getProductName()}
{/block}
{block name ="body"}
    ID: {$id->getProductId()}
    <br>
    Productname: {$id->getProductName()}
    <br>
    Description: {$id->getProductDescription()}
    <br>
    <hr/>
    <form id="form" name="form" action="" method="post">
        <input type="radio" name="delete" value={$id->getProductId()}>Delete Product</label>
        <input type="radio" name="save" value={$id->getProductId()}>Update Product</label>
        <input type="radio" name="save" value=0=>Create Product</label>
    <br>Productname
    <br><input type="text" name="newpagename" size=40 maxlength=40>
    <br>Productdescription
    <br><input type="text" name="newpagedescription" size=40 maxlength=40>
    <br><br>
    <input type="submit" value="commit">
    </form>
    <hr/>
    <a href="http://localhost:8080/Index.php?cl=product&page=list&admin=true">back to dashboard</a>

{/block}