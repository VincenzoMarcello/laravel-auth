<?php
// # VISTO CHE ABBIAMO SPOSTATO IL ProjectController
// # DOBBIAMO AGGIUNGERE AL namespace \Admin ALLA FINE
namespace App\Http\Controllers\Admin;

// # E IMPORTARE IL CONTROLLER
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// # IMPORTIAMO IL MODEL Project 
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // # PER VEDERLI TUTTI ALL
        // $projects = Project::all();

        // # PER FARE LA PAGINAZIONE E VEDERNE SOLO ALCUNI
        // # QUESTA PARTE DAL PRIMO E ARRIVA ALL'ULTIMO
        // $projects = Project::paginate(9);

        // # FACCIAMO LA PAGINAZIONE ORDINANDO DALL'ULTIMO PROJECT AL PRIMO
        // # TRAMITE IL METODO ORDERBYDESC DELL'id
        $projects = Project::orderByDesc('id')->paginate(9);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // # FACCIAMO UNA VARIABILE DATA CHE RICEVERA' I DATI DEL FORM
        $data = $request->all();

        // # E ISTANZIAMO UN NUOVO OGGETTO CHE CONTERRA' I DATI DEL FORM
        $project = new Project();
        // # ABBIAMO DUE MODI DI FARLO O SINGOLARMENTE PER OGNI VALORE
        // # OPPURE CON IL FILL E METTENDO IL FILLABLE NEL MODEL
        // # IN QUESTO CASO USIAMO IL SECONDO METODO
        // $project->name = $data['name'];
        // $project->link = $data['link'];
        // $project->description = $data['description'];
        // $project->save();

        $project->fill($data);
        $project->save();

        // # FACCIAMO IL REDIRECT IN MANIERA TALE CHE QUANDO SALVIAMO
        // # IL NUOVO PROGETTO CI RIPORTA A UNA ROTTA CHE VOGLIAMO
        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // # FACENDO LA Dependency injection QUINDI METTENDO Project $project INVECE DI $ID
        // # CI RISPARMIAMO LA RIGA SOTTO
        // $projects = Project::findOrFail($id);
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->all();
        $project->fill($data);
        $project->save();

        // # COME PER LO STORE FACCIAMO IL REDIRECT IN MANIERA TALE CHE QUANDO SALVIAMO
        // # IL PROGETTO MODIFICATO CI RIPORTA A UNA ROTTA CHE VOGLIAMO
        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index');
    }
}
