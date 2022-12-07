<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221206082922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD pizza_id_id INT NOT NULL, ADD pizza_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939889359C8F FOREIGN KEY (pizza_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398D41D1D42 FOREIGN KEY (pizza_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_F529939889359C8F ON `order` (pizza_id_id)');
        $this->addSql('CREATE INDEX IDX_F5299398D41D1D42 ON `order` (pizza_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939889359C8F');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398D41D1D42');
        $this->addSql('DROP INDEX IDX_F529939889359C8F ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398D41D1D42 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP pizza_id_id, DROP pizza_id');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
    }
}
