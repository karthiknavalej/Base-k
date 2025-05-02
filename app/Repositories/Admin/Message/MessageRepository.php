<?php

declare(strict_types=1);

namespace App\Repositories\Admin\Message;

// Model
use App\Models\Message;

// Resource
use App\Http\Resources\Admin\MessageResource;

// Exception
use App\Exceptions\ModelNotFoundException;

// Others
use Illuminate\Database\Eloquent\Collection;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @var model
    */
    protected $model;

    /**
     * @method __construct
    */
    public function __construct(Message $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records
     *
     * @method all
     *
     * @return Illuminate\Database\Eloquent\Collection
     *
    */
    public function all(): ?Collection
    {
        return $this->model->all();
    }

    /**
     * Find record by Id
     *
     * @method find
     *
     * @param  int $modelId
     *
     * @return App\Models\Message
     *
    */
    public function find(int $modelId): ?Message
    {
        $model = $this->model->find($modelId);
        if (!$model) {
            throw new ModelNotFoundException();
        }
        return $model;
    }

    /**
     * Create new record
     *
     * @method store
     *
     * @param  array $request
     *
     * @return App\Models\Message
     *
    */
    public function store(array $request): ?Message
    { 
        if(request()->has('file')) {
            $filename = request('file')->store('chat');
            $message=Message::create([
                'user_id' => request()->user()->id,
                'image' => $filename,
                'receiver_id' => request('receiver_id'),
                'status' => 'Sent',
            ]);
        }else{
            $message = auth()->user()->messages()->create(['status' => 'Sent', 'message' => $request['message']]);
        }
       
        return $message;
    }

    /**
     * Update existing record
     *
     * @method update
     *
     * @param  object $model
     *
     * @param  array $request
     *
     * @return bool
     *
    */
    public function update(object $model, array $request): bool
    {
        return $model->update($request);
    }

    /**
     * Permanently destroy record by id
     *
     * @method destroy
     *
     * @param  object $model
     *
     * @return bool
     *
    */
    public function destroy(object $model): bool
    {
        return $model->forceDelete();
    }

    /**
    * process objects
    *
    * @method process
    *
    * @param  object $model
    *
    * @param  bool $collection
    *
    * @return object
    *
    */
    public function process(object $data, bool $collection = false): ?object
    {
        if ($collection) {
            return MessageResource::collection($data);
        }
        return new MessageResource($data);
    }

    /**
    * return observer
    *
    * @method observe
    *
    * @return App\Models\Message
    *
    */
    public function observe(string $class): ?Message
    {
        return $this->model->observe($class);
    }

    /**
     * Get all private message records
     *
     * @method private message
     *
     * @return Illuminate\Database\Eloquent\Collection
     *
    */
    public function privateCommunication($request): ?Collection
    {
        $privateCommunication= Message::with('user')
        ->where(['user_id'=> auth()->id(), 'receiver_id'=> $request->id])
        ->orWhere(function($query) use($request){
            $query->where(['user_id' => $request->id, 'receiver_id' => auth()->id()]);
        })
        ->get();
        return $privateCommunication;
    }

    /**
     * Create new record
     *
     * @method storePrivateMessage
     *
     * @param  array $request
     *
     * @return App\Models\Message
     *
    */
    public function storePrivateMessage(array $request): ?Message
    { 
      
        if(request()->has('file')){
            $filename = request('file')->store('chat');
            $message=Message::create([
                'user_id' => request()->user()->id,
                'image' => $filename,
                'receiver_id' => $request['id'],
                'status' => 'Sent'
            ]);
        }else{
            $input['message']=$request['message'];
            $input['receiver_id']=$request['id'];
            $input['status'] = 'Sent';
            $message=auth()->user()->messages()->create($input);
        }
       
        return $message;
    }
}
