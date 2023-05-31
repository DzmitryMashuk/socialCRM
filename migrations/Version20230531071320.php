<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531071320 extends AbstractMigration
{
    const USER_TABLE = 'user';

    const CLIENT_TABLE = 'client';

    const SERVICE_CATALOG_GROUP_TABLE = 'service_catalog_group';

    const SERVICE_CATALOG_TABLE = 'service_catalog';

    const USERS = [
        [
            'email'    => 'admin@admin.admin',
            'roles'    => '["ROLE_ADMIN"]',
            'password' => '$2y$13$2t1u0Ayartt6CjnIZwTZkOwvTtVk8w/oJJCu/3xz4G2fNPlLlWPdG',
            'weekends' => '[]',
        ],
        [
            'email'    => 'maslovets@gmail.com',
            'roles'    => '[]',
            'password' => '$2y$13$7r8mgLucF2ecgE7jJ99Fc.eXaP79.M0VRQVZv7WrrcxiKSbL0l6Ii',
            'weekends' => '["1", "6", "7", "9", "13", "14", "20", "21", "27", "28"]',
        ],
    ];

    const CLIENTS = [
        [
            'first_name'     => 'Мария',
            'middle_name'    => 'Николаевна',
            'last_name'      => 'Филиппова',
            'age'            => '71',
            'phone'          => '+3752912345678',
            'guardian_name'  => 'Филиппов Владимир',
            'guardian_phone' => '+3752912345687',
            'visit_days'     => '["2", "3", "5", "10", "12", "16", "17", "19", "23", "24", "26", "30", "31"]',
        ],
        [
            'first_name'     => 'Валентина',
            'middle_name'    => 'Данилова',
            'last_name'      => 'Изотова',
            'age'            => '68',
            'phone'          => '+3752912345689',
            'guardian_name'  => 'Изотов Алексей',
            'guardian_phone' => '+3752912345698',
            'visit_days'     => '["2", "3", "5", "10", "12", "16", "17", "19", "23", "24", "26", "30", "31"]',
        ],
        [
            'first_name'     => 'Лидия',
            'middle_name'    => 'Антоновна',
            'last_name'      => 'Шурхай',
            'age'            => '76',
            'phone'          => '+3752912345679',
            'guardian_name'  => 'Шурхай Пётр',
            'guardian_phone' => '+3752912345697',
            'visit_days'     => '["2", "4", "8", "11", "15", "18", "22", "25", "29"]',
        ],
        [
            'first_name'     => 'Раиса',
            'middle_name'    => 'Лукъянова',
            'last_name'      => 'Радионова',
            'age'            => '73',
            'phone'          => '+3752912345689',
            'guardian_name'  => 'Радионов Анатолий',
            'guardian_phone' => '+3752912345698',
            'visit_days'     => '["2", "3", "5", "10", "12", "16", "17", "19", "23", "24", "26", "30", "31"]',
        ],
    ];

    const SERVICE_CATALOG = [
        'Консультационно - информационные'      => [
            '1.1. консультирование и информирование по вопросам оказания социальных услуг и социальной поддержки',
            '1.2. содействие в оформлении необходимых документов для реализации права на социальную поддержку и социальное обслуживание',
            '1.3. содействие в истребовании необходимых документов для реализации права на социальную поддержку и социальное обслуживание',
            '1.4. проведение информационных бесед',
        ],
        'Социально-бытовые - (платно)'          => [
            '2.0. покупка и доставка на дом продуктов питания, промышленных товаров первой необходимости',
            '2.1. доставка на дом горячего питания',
            '2.2. оказание помощи в приготовлении пищи',
            '2.3. приготовление простых блюд до 2-х блюд',
            '2.4. доставка воды (для проживающих в жилых помещениях без центрального водоснабжения)',
            '2.5. растопка печей',
            '2.6. сдача вещей в стирку, химчистку, ремонт и их доставка на дом',
            '2.7. протирание пыли с поверхности мебели',
            '2.8. вынос мусора',
            '2.9. подметание пола',
            '2.10. уборка пылесосом мягкой мебели, ковров и напольных покрытий',
            '2.11. чистка прикроватных ковриков и дорожек',
            '2.12. мытье пола',
            '2.13. мытье оконных стекол и оконных переплетов, протирание подоконников, очистка оконных рам от бумаги (проклейка оконных рам бумагой)',
            '2.14. смена штор и гардин',
            '2.15. уборка пыли со стен и потолков',
            '2.16. чистка ванны, умывальника (раковины)',
            '2.17. чистка газовой (электрической) плиты',
            '2.18. внесение платы из средств обслуживаемого лица за жилищно-коммунальные услуги, пользование жилым помещением, услуги связи',
            '2.19. доставка на дом материальной помощи (гуманитарной)',
            '2.20. очистка придомовых дорожек от снега в зимний период',
            '2.21. оказание помощи в одевании, снятии одежды',
            '2.22. оказание помощи в смене пост. белья',
            '2.23. причесывание',
            '2.24. помощь в принятии ванны',
            '2.25. мытье головы',
            '2.26. гигиеническая обработка ног и рук',
            '2.27. организация прогулки на свежем воздухе',
            '2.28. доставка (обеспечение) лекарственных средств и изделий медицинского назначения при необходимости',
        ],
        'Социально - педагогические'            => [
            '3.0. обучение пользованию компьютерной техникой, мобильным телефоном',
            '3.1. обеспечение книгами, журналами, газетами',
            '3.2. чтение вслух журналов, газет, книг',
            '3.3. содействие в посещении театров и других культурных мероприятий',
            '3.4. оказание помощи в посещении храма, организация встреч и духовных бесед со служителями храма',
        ],
        'Социально - посреднические'            => [
            '4.1. содействие в восстановлении и поддержании родственных связей',
            '4.2. представление интересов в государственных органах и организациях для защиты прав и законных интересов',
            '4.3. содействие в восстановлении документов, удостоверяющих личность подтверждающих право на льготы',
            '4.4. содействие в получении льгот и материальной помощи, предусмотренных законодательством',
            '4.5. содействие в получении социальных услуг, предоставляемых организациями, оказывающими социальные услуги',
            '4.6. содействие в получении услуг, предоставляемых организациями торговли, бытового обслуживания, связи и другими организациями',
            '4.7. содействие в получении юридических услуг',
            '4.8. содействие в назначении (получении) пенсии и других социальных выплат',
            '4.9. сопровождение в государственные организации здравоохранения',
            '4.10. содействие в организации ритуальных услуг при необходимости',
            '4.11. содействие в организации получения мед. помощи',
        ],
        'Социально - реабилитационные (платно)' => [
            '5.1. содействие в выполнении реабилитационных мероприятий в соответствии с индивидуальными программами реабилитации инвалила',
            '5.2. помощь в обеспечении технич. ср-вами соц-ной реабилитации, включенными в гос-ный реестр',
            '5.3. обучение пользованию техническими средствами социальной реабилитации при. необх.',
            '5.4. оказание первой помощи (померять давление, сахар, температуру. дать таблетку)',
            '5.5. оказание помощи в выполнении назначений, рекомендаций мед. работника',
        ],
    ];

    public function getDescription(): string
    {
        return 'Added users, clients and service catalog';
    }

    public function up(Schema $schema): void
    {
        foreach (self::USERS as $user) {
            $this->connection->insert(self::USER_TABLE, $user);
        }

        $userId = $this->connection->lastInsertId();

        foreach (self::CLIENTS as $client) {
            $client['user_id'] = $userId;
            $this->connection->insert(self::CLIENT_TABLE, $client);
        }

        foreach (self::SERVICE_CATALOG as $serviceCatalogGroupName => $serviceCatalogNames) {
            $this->connection->insert(self::SERVICE_CATALOG_GROUP_TABLE, ['name' => $serviceCatalogGroupName]);
            $serviceCatalogGroupId = $this->connection->lastInsertId();

            foreach ($serviceCatalogNames as $serviceCatalogName) {
                $this->connection->insert(self::SERVICE_CATALOG_TABLE, [
                    'name'                     => $serviceCatalogName,
                    'service_catalog_group_id' => $serviceCatalogGroupId,
                ]);
            }
        }
    }

    public function down(Schema $schema): void
    {
        #Do nothing
    }
}
