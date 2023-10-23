# TRACCIA

Creiamo con Laravel il nostro sistema di gestione del nostro Portfolio di progetti.
Oggi iniziamo un nuovo progetto che si arricchirà nel corso delle prossime lezioni: man mano aggiungeremo funzionalità e vedremo la nostra applicazione crescere ed evolvere.

Nel pomeriggio, rifate ciò che abbiamo visto insieme stamattina stilando tutto a vostro piacere utilizzando SASS.

**Descrizione:**
Ripercorriamo gli steps fatti a lezione ed iniziamo un nuovo progetto partendo dalla repo template https://github.com/TizianoN/103-laravel-boilerplate-auth
Iniziamo con il definire il layout, modello, migrazione, controller e rotte necessarie per il sistema portfolio:

-   Autenticazione: si parte con l'autenticazione e la creazione di un layout per back-office
-   Creazione del modello Project con relativa migrazione, seeder, controller e rotte
-   Per la parte di back-office creiamo un resource controller Admin\ProjectController per gestire tutte le operazioni CRUD dei progetti

## Bonus

Implementiamo la validazione dei dati dei Progetti nelle operazioni CRUD.

# SVOLGIMENTO

-   installo le dipendenze di back-end e di front-end e genero la key:

```
 composer i | npm i | php artisan key:generate
```

-   duplico il file env e faccio il collegamento al database del server ma prima:

    -   creo un database su phpMyAdmin in questo caso lo chiamo come la repo 'laravel-auth'
        e la tabella la chiamo 'projects'

-   faccio il comando sotto per fare il migrate che genererà la tabella degli utenti per il login:

```
php artisan migrate
```

-   e faccio partire i server

```
php artisan serve | npm run dev
```

-   Ora ci creiamo il model il resource controller e il seeder:

```
php artisan make:model Project -mscr
```

-   Ora andiamo nelle migration e ci creaimo le colonne della tabella projects del database e quindi andiamo su 'create_projects_table' e scegliamo cosa mettere:

```php
   public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); <--
            $table->text('description'); <--
            $table->string('link'); <--
            $table->string('slug'); <--
            $table->timestamps();
        });
    }
```

-   e facciamo il migrate:

```
 php artisan migrate
```

-   Ora andiamo nel seeder precisamente ProjectSeeder:

```php
  public function run(Faker $faker)
    {
        for ($i = 0; $i < 50; $i++) {
            $project = new Project();
            $project->name = $faker->catchPhrase();
            $project->description = $faker->text();
            $project->link = $faker->url();
            $project->slug = Str::slug($project->name);
            $project->save();
        }
    }
```

-   e ci importiamo le classi che ci servono:

```php
use App\Models\Project;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
```

-   dopodichè lanciamo il comando per salvare i valori nel db:

```
php artisan db:seed --class=ProjectSeeder
```

**ATTENZIONE:** siccome potrebbe capitare di dover fare un reset con il comando

```
 php artisan migrate:reset
```

per ad esempio inserire un nuovo dato nel migrate, facendo il reset perderei anche i dati degli users quindi quelli del login e si dovrebbero registrare nuovamente quindi per ovviare a questo facciamo un seeder solo degli users quindi creiamocelo:

```
 php artisan make:seeder UserSeeder
```

-   andiamo in UserSeeder:

```php
 public function run()
    {
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@admin.it";
        // # QUI USIAMO UN METODO PER HASHARE LA PASSWORD
        $user->password = Hash::make("password");
        $user->save();
    }

```

-   e ci importiamo questo per l'Hash:

```php
use Illuminate\Support\Facades\Hash;
```

-   Ora se facciamo il reset comunque verranno cancellate tutte le tabelle ma con un seed ricarichiamo i dati dell'utente il problema è che dobbiamo fare il migrate e due seed:

```
 php artisan migrate
```

```
php artisan db:seed --class=ProjectSeeder
```

```
php artisan db:seed --class=UserSeeder
```

-   Per ovviare anche a questo possiamo usare il DatabaseSeeder.php in seeders:

```php
 public function run()
    {
        // # CHIAMIAMO UN METODO call() CHE CONTERRA' UN ARRAY CON TUTTI I SEEDER
        // # CHE VOGLIAMO CHIAMARE IN MANIERA TALE CHE SE FACCIAMO UN REFRESH O UN RESET
        // # BASTERA' FARE php artisan db:seed E TUTTI I SEEDER NELLA call() SI AVVIERANNO
        $this->call([
            ProjectSeeder::class,
            UserSeeder::class
        ]);
    }
```

-   basterà poi fare:

```
 php artisan db:seed

 ATTENZIONE: se non ci sono classi da seedare nella call() questo comando non farà nulla
```

-   possiamo anche fare tutto in un colpo solo:

```
 php artisan migrate:refresh --seed
```

-   passiamo ai controller prima cosa da fare è spostare il ProjectController in Admin
    visto che è una cosa che riguarda l'utente loggato
