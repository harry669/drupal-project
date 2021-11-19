<?php
 
namespace Drupal\tl_session\Controller;
 
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
 
/**
 * Class TeacherContactController
 *
 * @package Drupal\tl_session\Controller
 */
class TeacherContactController extends ControllerBase {
 
  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;
 
  /**
   * The TeacherContactController constructor.
   *
   * @param \Drupal\Core\Form\FormBuilder $formBuilder
   *   The form builder.
   */
  public function __construct(FormBuilder $formBuilder) {
    $this->formBuilder = $formBuilder;
  }
 
  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * The Drupal service container.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('form_builder'));
  }
 
  /**
   * Callback for opening the modal form.
   */
  public function openModalForm() {

    $response = new AjaxResponse();
    // Get the modal form using the form builder.
    $modal_form = $this->formBuilder->getForm('Drupal\tl_session\Form\TeacherForm');
    // Add an AJAX command to open a modal dialog with the form as the content.
    $response->addCommand(new OpenModalDialogCommand('Contact form', $modal_form, ['width' => '555']));

    return $response;
  }


   public function createItem(Request $request)
   {
       //load entity here
        $node_id= \Drupal::request()->get('id');
        $nid=$node_id;
       $node_storage= \Drupal::entityTypeManager()->getStorage('node');
       $node= $node_storage->load($nid);
       $title= $node->get('title')->value;   
       return array(
          '#markup' => $title
       );
   }

   public function newItem()
   {
       $entity = \Drupal::entityTypeManager()->getStorage('node');
       $query = $entity->getQuery();

        $ids = $query->condition('status', 1)
       ->condition('type', 'article')#type = bundle id (machine name)
       ->sort('created', 'ASC') #sorted
       ->pager(15) #limit 15 items
       ->execute();


       //load multiple id's
       //isPublished()
       $articles = $entity->loadMultiple($ids);
       $article_1 = $articles['1'];
       $publish= $article_1->isPublished();
        return array(
          '#markup' => $publish
       );

    }

    public function fetchData()
    {
       $database= \Drupal::database();
       $query = $database->query("SELECT nid, type FROM {node}");
       $result = $query->fetchAll();

       kint($result);
       exit;

    }


    public function dynamicFetchData()
    {
          $database= \Drupal::database();
          $query = $database->select('node', 'nt')
                   ->condition('nt.nid', 0, '<>')
                   ->fields('nt', ['type','vid'])
                   ->range(0, 50);
          $result = $query->execute();
          foreach ($result as $record) {
                // Do something with each $record.
                     kint($record->vid);
                     exit;
                  }
    }
}