<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->database = $container->get('database');
    return $instance;
  }

  /**
   * Fetch.
   *
   * @return string
   *   Return Hello string.
   */
  public function Fetch() {
       
       /*
        try 
        {
            $result= $this->database->insert('mymodule')->fields(['name','age','uid'])
          ->values([
            'name' => 'akash',
            'age'  => 12,
            'uid'  => 2
          ])
        ->execute();
        }
        catch(\Throwable $e)
        {

        }
      */

        $query = $this->database->select('mymodule', 'm');
         $query->addExperission('COUNT(did)', 'did_count');
$query->condition('m.did', 3);
$query->fields('m');
//$query->addField('m', 'name','customer_name');
$result = $query->execute();
 foreach($result as $record)
 {
     kint($record);
     exit;
 }
//return $result->fetchField();

        //mult Insert Query
      /*
      $values = [
    [
      'name' => 'Jhonf',
      'age' => 30,
    ],
    [
      'name' => 'Jandf',
      'age' => 28,
    ],
  ];
  $database = \Drupal::database();
  $query = $database->insert('mymodule')->fields(['name', 'age']);
  foreach ($values as $developer) {
    $query->values($developer);
  }
  $query->execute();
  */

   return array(
      '#markup' => '<p>Data Created</p>'
   );

}

public function updateData()
{

     //join operation
     $database1 = \Drupal::database();
     $query= $database1->select('mymodule','m');
     $query->fields('m');
     $query->join('users','u','u.uid=m.uid');
     $query->fields('u',['uuid']);
     $result= $query->distinct()->execute();
     foreach($result as $record) {
           kint($record);
           exit;
     }
     


    /*
    $database1 = \Drupal::database();
    $record_update= $database1->update('mymodule')->fields(['age' => 56,])
                    ->condition('name', 'Jhonf','=')
                    ->execute();
                    */

           return array(
      '#markup' => '<p>Data Updated</p>'
   );
}

public function deleteData()
{     

      $database2 = \Drupal::database();
       $query = $database2->select('users', 'u')
            ->fields('u', ['uid']);
           $query->addExpression('count(uid)', 'uid_node_count');
           $query->groupBy("u.uid");
           
           $result=$query->execute();

          foreach($result as $record)
          {
             kint($record);
             exit;
          }
      /*
    $record_update= $database2->delete('mymodule')
                    ->condition('name', 'Jhonf','=')
                    ->execute();
     */
           return array(
      '#markup' => '<p>Data Deleted </p>'
   );
}

public function upsertData()
{
     $value= [
          'name' => 'akash',
          'age' => 12,
          'did' => 3,
      ];


     $database3 = \Drupal::database();
     $record_upsert= $database3->upsert('mymodule')
                     ->fields(['name','age'])
                     ->key('did');

      $record_upsert->values($value);
      $result= $record_upsert->execute();


           return array(
             '#markup' => $result
          );


}


  public function mergeData()
  {
      /*
        $connection->merge('example')
        ->insertFields([
      'field1' => $value1,
      'field2' => $value2,
       ])
        ->updateFields([
       'field1' => $alternate1,
      ])
     ->key('name', $name)
    ->execute();
       */


       /*
          $connection->merge('example')
          ->key('name', $name)
         ->fields([
         'field1' => $value1,
         'field2' => $value2,
           ])
         ->execute();
       */
  }

  public function serviceTest()
  {
      $service= \Drupal::service('mymodule.default');
      $result= $service->Fetch();
      kint($result);
      exit;
  }

  

}
