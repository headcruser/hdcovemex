<?php

namespace HelpDesk\Entities;

use HelpDesk\Builder\SolicitudeQuery;
use HelpDesk\Entities\Admin\User;
use HelpDesk\Entities\Config\Status;
use HelpDesk\Notifications\CommentSolicitudeNotification;
use HelpDesk\Observers\SolicitudeActionObserver;

use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitude extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'solicitudes';

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha',
        'usuario_id',
        'ticket_id',
        'estatus_id',
        'titulo',
        'incidente',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_At'
    ];

    protected $dates = ['fecha'];

    public static function boot()
    {
        parent::boot();

        Solicitude::observe(new SolicitudeActionObserver);
    }

    /**
     *
     * Crea una nueva instancia de el constructor de consultas Eloquent
     * para el modelo.
     *
     * Este método separa los filtros a un nueva clase.
     *
     * @param  $query
     * @return SolicitudeQuery|static
     */
    public function newEloquentBuilder($query)
    {
        return new SolicitudeQuery($query);
    }

    /**
     * Obtiene el archivo asociado al modelo
     */
    public function media()
    {
        return $this->morphOne(Media::class, 'media');
    }


    public function status()
    {
        return $this->belongsTo(Status::class, 'estatus_id')->withDefault([
            'name'          => 'SE',
            'display_name'  => 'Sin Estatus'
        ]);
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'usuario_id')->withDefault([
            'nombre'    => 'S/N',
            'email'     => 'S/E',
            'telefono'  => 'S/T',
        ]);
    }

    public function revisadoPor()
    {
        return $this->belongsTo(User::class, 'revisado_por')->withDefault();
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }

    public function sendCommentNotification($comment)
    {
        $jefesDepartamento = User::withRoles('soporte', 'jefatura', 'admin')->get();
        // ->when(!$comment->usuario_id, function ($q) {
        //     $q->orWhereHas('roles', function ($q) {
        //         return $q->where('display_name', 'Administrador');
        //     });
        // })
        // ->when($comment->user, function ($q) use ($comment) {
        //     $q->where('id', '!=', $comment->usuario_id);
        // })

        $notification = new CommentSolicitudeNotification($comment);

        Notification::send($jefesDepartamento, $notification);

        return $jefesDepartamento;
    }
}
