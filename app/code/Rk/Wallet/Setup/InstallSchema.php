<?php
namespace Rk\Wallet\Setup;


class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
 public function install(
 \Magento\Framework\Setup\SchemaSetupInterface $setup,
 \Magento\Framework\Setup\ModuleContextInterface $context
 ){
 $installer = $setup;
 $installer->startSetup();

 $table = $installer->getConnection()
 ->newTable($installer->getTable('Cashback_Details'))
 ->addColumn(
 'id',
 \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
 null,
 ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
 'Id'
 )
 ->addColumn(
 'product_id',
 \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
 255,
 ['nullable' => false],
 'productId'
 )
 ->addColumn(
 'customer_id',
 \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
 255,
 ['nullable' => false],
 'cid'
  )->addColumn(
 'product_name',
 \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
 255,
 ['nullable' => false],
 'Title'
 )
 ->addColumn(
 'discount_Money',
 \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
 255,
 ['nullable' => false],
 'dis'
  )
  ->addColumn(
 'amount_credit_days',
 \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
 255,
 ['nullable' => false],
 'acd'
  )
  
 ->addColumn(
 'created_at',
 \Magento\Framework\Db\Ddl\Table::TYPE_TIMESTAMP,
 null,
 ['nullable' => false, 'default' => \Magento\Framework\Db\Ddl\Table::TIMESTAMP_INIT],
 'Created At'
 );
 $installer->getConnection()->createTable($table);
 $installer->endSetup();
 }
}
?>