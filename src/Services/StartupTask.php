<?php


namespace App\Services;

use App\Entity\TableCounter;
use App\Repository\TableCounterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\String\UnicodeString;

/**
 * @Service()
 * @Tag(name="kernel.event_listener", event=KernelEvents::REQUEST)
 */

class StartupTask  implements EventSubscriberInterface
{

    public $em;
    public $repo;
    public      $mailer;
    public function __construct(EntityManagerInterface $em, MailerInterface $mailer, TableCounterRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();
        $setting = [];
        // if ($request->isMethod('POST')) {
        //     $tables = [
        //         "lotissements_zones", "lotissements_plans",
        //         "lotissements_users", "lotissements_parcelles",
        //         "lotissements_lotissements", "lotissements_regions",
        //         "lotissements_statuts_demandeurs", "lotissements_statuts_lotissements",
        //         "lotissements_dimensions", "lotissements_localites",
        //         "lotissements_departements", "lotissements_demandes",
        //         "lotissements_demandeurs"
        //     ];

        //     //le nombre de demandes 
        //     try {
        //         $sql_differente_statut =
        //             "SELECT s.denomination AS nom_statut, COUNT(*) AS nombre_demandes
        //             FROM lotissements_demandes ld
        //             JOIN lotissements_statuts_lotissements s ON ld.statut_id = s.id
        //             GROUP BY ld.statut_id, s.denomination;";


        //         $connT = $this->em->getConnection();
        //         $stmtT = $connT->prepare($sql_differente_statut);

        //         $resultSetT = $stmtT->executeQuery();
        //         $rc = $resultSetT->fetchAllAssociative();


        //         foreach ($rc as  $value) {

        //             $tableCounterName = $this->repo->findOneBy(['name' => $value['nom_statut']]);
        //             if ($tableCounterName) {
        //                 $tableCounterName->setValue($value['nombre_demandes'] ? $value['nombre_demandes'] : 0);
        //             } else {
        //                 $tableCounterName = new TableCounter();
        //                 $tableCounterName->setValue($value['nombre_demandes'] ? $value['nombre_demandes'] : 0);
        //                 $tableCounterName->setName($value['nom_statut']);
        //             }
        //             $this->em->persist($tableCounterName);
        //         }



        //         $setting[] = array(
        //             'name' => $tableCounterName->getName(),
        //             'value' =>  $tableCounterName->getValue()
        //         );
        //     } catch (\Throwable $th) {
        //         // dd($th);
        //         echo $th;
        //     }


        //     foreach ($tables as $table) {
        //         $sql = 'SELECT COUNT(*) as count FROM ' . $table;
        //         try {
        //             $connT = $this->em->getConnection();
        //             $stmtT = $connT->prepare($sql);
        //             $resultSetT = $stmtT->executeQuery();
        //             $r = $resultSetT->fetchAllAssociative();
        //             $count = $r[0]['count'];

        //             $mot = new UnicodeString($table);
        //             $name =  $mot->replace('lotissements_', '');
        //             $tableCounter = $this->repo->findOneBy(['name' => $name]);

        //             if ($tableCounter) {
        //                 $tableCounter->setValue($count);
        //             } else {
        //                 $tableCounter = new TableCounter();
        //                 $tableCounter->setValue($count);
        //                 $tableCounter->setName($name);
        //             }
        //             $setting[] = array(
        //                 'name' => $tableCounter->getName(),
        //                 'value' =>  $tableCounter->getValue()
        //             );

        //             $this->em->persist($tableCounter);
        //         } catch (Exception $e) {
        //             $e =  sprintf('<error>Error occurred while counting rows in %s: %s</error>', $table, $e->getMessage());
        //             // dump($e);
        //         }
        //     }
        //     $file = 'config/stats-db.json';
        //     $dir = dirname($file);
        //     if (!is_dir($dir)) {
        //         mkdir($dir, 0775, true);
        //     }
        //     file_put_contents($file, json_encode($setting));
        //     $this->em->flush();
        // }
    }
}