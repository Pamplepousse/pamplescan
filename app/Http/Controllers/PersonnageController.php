<?php namespace App\Http\Controllers;

use App\Models\Personnage;
use Illuminate\Http\Request;
use App\Models\Manga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str; 

class PersonnageController extends Controller
{
    // Display the list of characters for a specific manga
    public function index($idmanga)
    {
        $manga = Manga::with('personnages')->findOrFail($idmanga); // Retrieve the manga with its characters
        $personnages = $manga->personnages;

        return view('personnages.index', compact('manga', 'personnages'));
    }

    // Display the details of a specific character
    public function show($idmanga, $idpersonnage)
    {
        $manga = Manga::findOrFail($idmanga); // Retrieve the manga
        $personnage = Personnage::where('idmanga', $idmanga)->findOrFail($idpersonnage); // Retrieve the character within the manga

        return view('personnages.show', compact('manga', 'personnage'));
    }

    // Show the form to create a new character
    public function create(Request $request)
    {
        $idmanga = $request->idmanga; // Get the manga ID from the request
        return view('personnages.create', compact('idmanga'));
    }

    // Store a newly created character in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'idmanga' => 'required|exists:mangas,idmanga',
            'nom' => 'nullable|string|max:255|required_without_all:prenom,surnom',
            'prenom' => 'nullable|string|max:255|required_without_all:nom,surnom',
            'surnom' => 'nullable|string|max:255|required_without_all:nom,prenom',
            'sexe' => 'required|in:Masculin,Féminin',
            'espece' => 'required|string|max:255',
            'en_vie' => 'required|in:oui,non',
            'postetravail' => 'required|string|max:255',
            'descriptionphysique' => 'nullable|string',
            'descriptiongeneral' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ], [
            'nom.required_without_all' => 'Veuillez fournir soit un prénom, soit un nom, soit un surnom.',
            'prenom.required_without_all' => 'Veuillez fournir soit un prénom, soit un nom, soit un surnom.',
            'surnom.required_without_all' => 'Veuillez fournir soit un prénom, soit un nom, soit un surnom.',
        ]);

        $personnageData = [
            'prenom' => $validatedData['prenom'],
            'sexe' => $validatedData['sexe'],
            'espece' => $validatedData['espece'],
            'pseudo' => $request->pseudo,
            'en_vie' => $validatedData['en_vie'], // Use directly the value 'oui' or 'non'
            'poste_travail' => $validatedData['postetravail'],
            'description_physique' => $validatedData['descriptionphysique'],
            'description_generale' => $validatedData['descriptiongeneral'],
            'idmanga' => $validatedData['idmanga'],
            'surnom' => $validatedData['surnom'],
        ];

        // Check if the name is present before adding it to the array
        if (isset($validatedData['nom'])) {
            $personnageData['nom'] = $validatedData['nom'];
        }

        // Save the image if there is one
        if ($request->hasFile('image')) {
            $idmanga = $validatedData['idmanga'];
            $filename = Str::slug($validatedData['prenom'], '_') . '_' . uniqid() . '.jpg'; 
            $destinationPath = public_path("picture/{$idmanga}/character");
            $request->file('image')->move($destinationPath, $filename);
            $personnageData['image'] = "picture/{$idmanga}/character/{$filename}";
        }

        Personnage::create($personnageData);

        return redirect()->route('personnages.index', ['idmanga' => $validatedData['idmanga']])->with('success', 'Character added successfully.');
    }

    // Show the form to edit a specific character
    public function edit($idmanga, $idpersonnage)
    {
        $personnage = Personnage::where('idmanga', $idmanga)->findOrFail($idpersonnage); // Retrieve the character
        return view('personnages.edit', compact('personnage', 'idmanga'));
    }

    // Update the specified character in the database
    public function update(Request $request, $idmanga, $idpersonnage)
    {
        $validatedData = $request->validate([
            'idmanga' => 'required|exists:mangas,idmanga',
            'nom' => 'nullable|string|max:255',
            'prenom' => 'required|string|max:255',
            'surnom' => 'nullable|string|max:255',
            'sexe' => 'required|in:Masculin,Féminin',
            'espece' => 'required|string|max:255',
            'en_vie' => 'required|in:oui,non',
            'postetravail' => 'required|string|max:255',
            'descriptionphysique' => 'nullable|string',
            'descriptiongeneral' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $personnage = Personnage::where('idmanga', $idmanga)->findOrFail($idpersonnage); // Retrieve the character

        $personnage->update([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'surnom' => $validatedData['surnom'],
            'sexe' => $validatedData['sexe'],
            'espece' => $validatedData['espece'],
            'pseudo' => $request->pseudo,
            'en_vie' => $validatedData['en_vie'],
            'poste_travail' => $validatedData['postetravail'],
            'description_physique' => $validatedData['descriptionphysique'],
            'description_generale' => $validatedData['descriptiongeneral'],
        ]);

        // Update the image if a new one is uploaded
        if ($request->hasFile('image')) {
            $idmanga = $validatedData['idmanga'];
            $filename = uniqid() . '_' . Str::slug($validatedData['prenom'], '_') . '.jpg';
            $destinationPath = public_path("picture/character/{$idmanga}");
            $request->file('image')->move($destinationPath, $filename);
            $personnage->update(['image' => "picture/character/{$idmanga}/{$filename}"]);
        }

        return redirect()->route('personnages.show', ['idmanga' => $idmanga, 'idpersonnage' => $idpersonnage])->with('success', 'Character updated successfully.');
    }

}