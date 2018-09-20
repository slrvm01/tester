<h1 class="title">Vai pazīsti Latviju?</h1>
<form class="start-form js-start-form">
    <div class="input-wrapper">
        <input class="input" type="text" name="name" placeholder="Vārds">
    </div>
    <div class="select-wrapper">
        <select name="test" class="select">
            <option disabled selected value="">Izvēlies testu</option>
            <? foreach ($test_list as $item): ?>
            <option value="<?= $item->id ?>"><?= $item->title ?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class="input-wrapper">
        <input class="submit" type="submit" value="Sākt">
    </div>
</form>