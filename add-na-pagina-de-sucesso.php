<!-- resumo da compra -->
<div id="resumo-da-compra" style="margin-top:100px;">
<h6 style="text-align: center">RESUMO DO PEDIDO</h6> 
<?php 
if ($this->getOrderId()) {
$OrderNumber = $this->getOrderId();//Put your order Number here
$_order = Mage::getModel('sales/order')->load($OrderNumber, 'increment_id');
?>

<?php echo $this->getStatusHistoryRssUrl($_order) ?>
<p class="order-date" style="text-align: center;margin-bottom: 50px"><?php echo $this->__('Order Date: %s', $this->formatDate($_order->getCreatedAtStoreDate(), 'long')) ?></p>
<?php if (!$_order->getIsVirtual()): ?>

<div class="row customer-info-row order-view">
	<div class="col-md-6">
		<div class="box">
			<div class="box-title">
                <h6><?php echo $this->__('Billing Address') ?></h6>
            </div>
			
			<div class="box-content">
				<address><?php echo $_order->getBillingAddress()->format('html') ?></address>
			</div>
		</div>
	</div>
	<?php if (!$_order->getIsVirtual()): ?>
		<div class="col-md-6">
			<div class="box">
				<div class="box-title">
					<h6><?php echo $this->__('Shipping Address') ?></h6>
				</div>
				
				<div class="box-content">
					<address><?php echo $_order->getShippingAddress()->format('html') ?></address>
				</div>
			</div>
		</div>
	<?php endif ?>
</div>

<br/>

<div class="row customer-info-row order-view">
	<?php if (!$_order->getIsVirtual()): ?>
		<div class="col-md-6">
			<div class="box">
				<div class="box-title">
					<h6><?php echo $this->__('Entrega Escolhida') ?></h6>
				</div>
				
				<div class="box-content">
					<?php if ($_order->getShippingDescription()): ?>
						<?php echo $this->escapeHtml($_order->getShippingDescription()) ?>
					<?php else: ?>
						<p><?php echo $this->helper('sales')->__('No shipping information available'); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif ?>
	<div class="col-md-6">
		<div class="box">
			<div class="box-title">
                <h6><?php echo $this->__('Meio de Pagamento Escolhido') ?></h6>
            </div>
			
			<div class="box-content">
				<?php $payment_method_title = $_order->getPayment()->getMethodInstance()->getTitle();
				echo $payment_method_title ?>
			</div>
		</div>
	</div>
</div>

<br/>
<?php endif; ?>

   <?php 
    $order_id = $this->getOrderId();
    $order_details = Mage::getModel('sales/order')->loadByIncrementId($order_id); 
?>
    <table class="cart_table table table-hover" id="my-orders-table" summary="Produtos Vendidos">
    <thead>
		<tr>
        
        <th><?php echo $this->__('Nome') ?></th>
        <th><?php echo $this->__('SKU') ?></th>
        <th><?php echo $this->__('Unit Price') ?></th>
        <th><?php echo $this->__('Qty') ?></th>
        <th><?php echo $this->__('SubTotal') ?></th>
    </tr>
		</thead>

    <?php foreach($order_details->getAllVisibleItems() as $item): 
    $configItem = Mage::getModel('catalog/product')->loadByAttribute('sku', $item->getSku());
    ?> 
        <tr>
           
            <td><b><?php echo $item->getName() ?></b></td>
            <td><?php echo $item->getSku() ?></td>
            <td><?php echo Mage::helper("core")->currency($item->getPrice()) ?></td>
            <td><?php echo round($item->getQtyOrdered(), 0) ?></td>
            <td><?php echo Mage::helper("core")->currency($item->getPrice()) ?></td>
        </tr>
    <?php endforeach ?>
       <tfoot>
       <tr>
		   <td class="a-right" colspan="4">Embalagem e entrega</td>
      		<td class="last a-right"><?php echo Mage::helper("core")->currency($order_details->getShippingAmount())?></td>
       </tr>
       
       <?php if($order_details->getDiscountAmount()) { ?>
       <tr>
		   <td class="a-right" colspan="4">Desconto</td>
      		<td class="last a-right"><?php echo Mage::helper("core")->currency($order_details->getDiscountAmount())?></td>
       </tr>
       <?php } // fecha if desconto?>
       
       <tr>
       	<td class="a-right" colspan="4"><b>Valor total</b></td>
       	<td class="last a-right"><?php echo Mage::helper("core")->currency($order_details->getGrandTotal())?></td>
       </tr>
       
       </tfoot>
        </table>
        
        
         <?php echo $this->getChildHtml('items'); ?>
   <?php } ?>
  </div><!--#my-account --> 
