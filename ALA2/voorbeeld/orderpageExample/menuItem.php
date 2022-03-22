<!DOCTYPE html>
<html>
<script src="http://code.jquery.com/jquery-1.9.0.min.js"></script>

<?php 

class MenuItem {
    public $id;
    public $name;
    public $desc;
    public $basePrice;
    public $specializations;

    //Basic constructor function.
    public function __construct(int $id, string $name, string $desc, float $price, array $specializations)
    {
        $this->id = $id;
        $this->name = $name;
        $this->desc = $desc;
        $this->basePrice = $price;
        $this->specializations = $specializations;
    }

    //Function to load in the object on the screen.
    function render () {

        if ($this->desc){
            $text = $this->desc;
        } else {
            $text = 'Geen info beschikbaar';
        }

        //If any data is null, do not load the object.
        if (!$this->name || !$this->basePrice || empty($this->specializations)){
            return false;
        } else {
            ?> 
            <form class='orderItem' method='POST'>
            <input type='hidden' name='productName' value=<?php echo $this->name; ?>>
            <input type='hidden' name='id' value=<?php echo $this->id; ?>>
            <div class='itemDesc' style="order: 4"> <?php echo $this->name . ':  ' . $text; ?></div>
            <div class='row' style='order: 2'>
            <select id=<?php echo 'select' . $this->id; ?> class='selectSpec' name='spec'>
            <option value=''>Kies een grootte</option>
            <?php
            //Dynamicly load all specialisations as options.
            foreach($this->specializations as $option){
                echo "<option value=".$option['id'] . " data-price" . $this->id . "=" . sprintf("%.2f", round($option['price_multiplier'] * $this->basePrice, 2)) .">" . $option['name']."    € ".sprintf("%.2f", round($option['price_multiplier'] * $this->basePrice, 2)) . "</option>";
            }
            ?>
            </select>
            <input type='hidden' name='price' id=<?php echo 'price' . $this->id; ?>>
            </div>
            <button class='submitBtn' style="order: 1">Voeg aan bestelling toe</button>
            </form>

            
            <script>
                //JQuery eventlistener (inspirition from https://stackoverflow.com/a/30923863), if the select changes, this eventlistener gets the value from 'data-price' in the option and sets the input name='price' value to that of the data-price.
                $('<?php echo '#select' . $this->id; ?>').change(function () {
                var price=$(this).find('option:selected', this).attr('<?php echo 'data-price' . $this->id; ?>');
                $('<?php echo '#price' . $this->id; ?>').val(price);
                });
            </script>

            <?php
        }
    }
}

?>

</html>