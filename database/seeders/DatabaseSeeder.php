<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Materia;
use App\Models\Grupo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ──────────────────────────────────────────────────────────────────────
        // USUARIOS
        // ──────────────────────────────────────────────────────────────────────

        // Admin
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@example.com',
            'password' => Hash::make('temporal1'),
            'rol'      => 'admin',
        ]);

        $alumno = User::create([
            'name'     => 'Milton Estuardo Torres Meraz',
            'email'    => 'merazmilton9@gmail.com',
            'password' => Hash::make('temporal1'),
            'rol'      => 'alumno',
        ]);

        // Alumno extra
        $alumno2 = User::create([
            'name'     => 'Renata Lara',
            'email'    => 'renata@example.com',
            'password' => Hash::make('temporal1'),
            'rol'      => 'alumno',
        ]);

        // Profesores (tomados del portal IMAT)
        $profesoresData = [
            'Meade Collins Jaime Federico'      => 'meade@example.com',
            'Reyes Castillo Rito'               => 'reyes.castillo@example.com',
            'Nuñez Varela Alberto Salvador'     => 'nunez.varela@example.com',
            'Nava Muñoz Sandra Edith'           => 'nava.munoz@example.com',
            'Martinez Murillo Raul Antonio'     => 'martinez.murillo@example.com',
            'Martinez Perez Francisco Eduardo'  => 'martinez.perez@example.com',
            'Hernandez Castro Froylan Eloy'     => 'hernandez.castro@example.com',
            'De La Cruz Lopez Miguel Angel'     => 'delacruz@example.com',
            'Muniz Sandate Salvador'            => 'muniz@example.com',
            'Vaca Rivera Silvia Luz'            => 'vaca@example.com',
            'Perez Gonzalez Hector Gerardo'     => 'perez.gonzalez@example.com',
            'Varela Tristan Gerardo Antonio'    => 'varela.tristan@example.com',
            'Rodriguez Sanchez Jose de Jesus'   => 'rodriguez.sanchez@example.com',
            'Gomez Vazquez Francisco Javier'    => 'gomez.vazquez@example.com',
            'Torres Reyes Francisco Javier'     => 'torres.reyes@example.com',
            'Avila Montoya Clara Rosalia'       => 'avila@example.com',
            'Reyes Cardenas Oscar'              => 'reyes.cardenas@example.com',
            'Hernandez Morales Carlos Alberto'  => 'hernandez.morales@example.com',
            'Ortega Gutierrez Luis Octavio'     => 'ortega@example.com',
            'Acosta Espinoza Juan Jose'         => 'acosta@example.com',
            'Juarez Martinez Uriel'             => 'juarez@example.com',
            'Ordaz Narvaez Oscar Alejandro'     => 'ordaz@example.com',
        ];
 
        $profesorIds = [];
        foreach ($profesoresData as $nombre => $email) {
            $p = User::create([
                'name'     => $nombre,
                'email'    => $email,
                'password' => Hash::make('temporal1'),
                'rol'      => 'profesor',
            ]);
            $profesorIds[$nombre] = $p->id;
        }

        // ──────────────────────────────────────────────────────────────────────
        // MATERIAS  (clave, nombre, semestre, área, créditos, tipo)
        // Fuente: plan de estudios ISI – UASLP
        // ──────────────────────────────────────────────────────────────────────
        $materiasData = [
            // Semestre 1
            ['clave'=>'2229','nombre'=>'Pensamiento Algorítmico',              'semestre'=>1,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2150','nombre'=>'Temas Selectos de Matemáticas',        'semestre'=>1,'area'=>'Ciencias Básicas y Matemáticas',  'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2151','nombre'=>'Matemáticas Discretas I',              'semestre'=>1,'area'=>'Ciencias Básicas y Matemáticas',  'creditos'=>5,'tipo'=>'T'],
            // Semestre 2
            ['clave'=>'2231','nombre'=>'Estructuras de Datos I',               'semestre'=>2,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2152','nombre'=>'Matemáticas Discretas II',             'semestre'=>2,'area'=>'Ciencias Básicas y Matemáticas',  'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2233','nombre'=>'Lenguajes de Programación',            'semestre'=>2,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            // Semestre 3
            ['clave'=>'2232','nombre'=>'Estructuras de Datos II',              'semestre'=>3,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2234','nombre'=>'Tecnología Orientada a Objetos',       'semestre'=>3,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2111','nombre'=>'Análisis Numérico',                    'semestre'=>3,'area'=>'Ciencias Básicas y Matemáticas',  'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2112','nombre'=>'Probabilidad y Estadística',           'semestre'=>3,'area'=>'Ciencias Básicas y Matemáticas',  'creditos'=>5,'tipo'=>'T'],
            // Semestre 4
            ['clave'=>'2235','nombre'=>'Algoritmos y Complejidad',             'semestre'=>4,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2236','nombre'=>'Interfaces Gráficas con Aplicaciones', 'semestre'=>4,'area'=>'Ciencias de la Ingeniería',       'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2113','nombre'=>'Modelado Matemático',                  'semestre'=>4,'area'=>'Ciencias Básicas y Matemáticas',  'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2252','nombre'=>'Sistemas Operativos',                  'semestre'=>4,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            // Semestre 5
            ['clave'=>'2206','nombre'=>'Estructuras de Datos Avanzadas',       'semestre'=>5,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2237','nombre'=>'Aplicaciones Web Interactivas',        'semestre'=>5,'area'=>'Ciencias de la Ingeniería',       'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2238','nombre'=>'Fundamentos de Desarrollo Web',        'semestre'=>5,'area'=>'Ciencias de la Ingeniería',       'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2304','nombre'=>'Ingeniería de Software',               'semestre'=>5,'area'=>'Ciencias de la Ingeniería',       'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2008','nombre'=>'Seminario de Medio Término',           'semestre'=>5,'area'=>'Ciencias Sociales y Humanidades', 'creditos'=>3,'tipo'=>'T'],
            ['clave'=>'2228','nombre'=>'Supercomputo',                         'semestre'=>5,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            // Semestre 6
            ['clave'=>'2050','nombre'=>'Proyectos Computacionales I',          'semestre'=>6,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2239','nombre'=>'Fundamentos de Desarrollo Móvil',      'semestre'=>6,'area'=>'Ciencias de la Ingeniería',       'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2244','nombre'=>'Diseño de Interfaces',                 'semestre'=>6,'area'=>'Ciencias de la Ingeniería',       'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2313','nombre'=>'Administración de Bases de Datos',     'semestre'=>6,'area'=>'Ciencias de la Ingeniería',       'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2085','nombre'=>'Computación y Sociedad',               'semestre'=>6,'area'=>'Ciencias Sociales y Humanidades', 'creditos'=>3,'tipo'=>'T'],
            // Semestre 7
            ['clave'=>'2051','nombre'=>'Proyectos Computacionales II',         'semestre'=>7,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2245','nombre'=>'Aplicaciones Web Escalables',          'semestre'=>7,'area'=>'Ciencias de la Ingeniería',       'creditos'=>5,'tipo'=>'T'],
            // Semestre 8
            ['clave'=>'2052','nombre'=>'Proyectos Computacionales III',        'semestre'=>8,'area'=>'Ciencias de la Computación',      'creditos'=>5,'tipo'=>'T'],
            ['clave'=>'2053','nombre'=>'Administración de Proyectos I',        'semestre'=>8,'area'=>'Ciencias Sociales y Humanidades', 'creditos'=>5,'tipo'=>'T'],
            // Semestre 9
            ['clave'=>'2054','nombre'=>'Administración de Proyectos II',       'semestre'=>9,'area'=>'Ciencias Sociales y Humanidades', 'creditos'=>5,'tipo'=>'T'],
        ];
 
        $materias = []; // clave => Model
        foreach ($materiasData as $m) {
            $materias[$m['clave']] = Materia::create([
                'clave'       => $m['clave'],
                'nombre'      => $m['nombre'],
                'semestre'    => $m['semestre'],
                'area'        => $m['area'],
                'creditos'    => $m['creditos'],
                'tipo'        => $m['tipo'],
                'descripcion' => null,
            ]);
        }

        // ──────────────────────────────────────────────────────────────────────
        // GRUPOS  (tomados directamente del portal IMAT)
        // Formato horario: "Días HH-HH" ej. "Lun-Mié-Vie 9-10"
        // ──────────────────────────────────────────────────────────────────────
        $grupos = [
            // Pensamiento Algorítmico
            ['materia'=>'2229','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 7-8',  'salon'=>'I-LCB-3','cupo'=>30,'profesor'=>'Muniz Sandate Salvador'],
            ['materia'=>'2229','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 10-11','salon'=>'I-13',   'cupo'=>30,'profesor'=>'Vaca Rivera Silvia Luz'],
            ['materia'=>'2229','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 13-14','salon'=>'I-LCB-1','cupo'=>30,'profesor'=>'Hernandez Castro Froylan Eloy'],
            ['materia'=>'2229','grupo'=>'5','horario'=>'Lun-Mar-Mié-Jue-Vie 19-20','salon'=>'I-LCA-1','cupo'=>30,'profesor'=>'Muniz Sandate Salvador'],
            ['materia'=>'2229','grupo'=>'6','horario'=>'Lun-Mar-Mié-Jue-Vie 18-19','salon'=>'I-LCB-1','cupo'=>30,'profesor'=>'Juarez Martinez Uriel'],
            ['materia'=>'2229','grupo'=>'7','horario'=>'Lun-Mar-Mié-Jue-Vie 12-13','salon'=>'I-14',   'cupo'=>30,'profesor'=>'Juarez Martinez Uriel'],

            // Temas Selectos de Matemáticas
            ['materia'=>'2150','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 10-11','salon'=>'I-02','cupo'=>30,'profesor'=>'Avila Montoya Clara Rosalia'],
            ['materia'=>'2150','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 13-14','salon'=>'I-02','cupo'=>30,'profesor'=>'Avila Montoya Clara Rosalia'],
            ['materia'=>'2150','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 11-12','salon'=>'I-01','cupo'=>30,'profesor'=>'Avila Montoya Clara Rosalia'],
            ['materia'=>'2150','grupo'=>'4','horario'=>'Lun-Mar-Mié-Jue-Vie 12-13','salon'=>'I-02','cupo'=>30,'profesor'=>'Avila Montoya Clara Rosalia'],

            // Matemáticas Discretas I
            ['materia'=>'2151','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 9-10', 'salon'=>'I-05','cupo'=>30,'profesor'=>'Reyes Cardenas Oscar'],
            ['materia'=>'2151','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 12-13','salon'=>'I-05','cupo'=>30,'profesor'=>'Hernandez Morales Carlos Alberto'],
            ['materia'=>'2151','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 14-15','salon'=>'I-03','cupo'=>30,'profesor'=>'Ortega Gutierrez Luis Octavio'],
            ['materia'=>'2151','grupo'=>'8','horario'=>'Lun-Mar-Mié-Jue-Vie 11-12','salon'=>'I-02','cupo'=>30,'profesor'=>'Avila Montoya Clara Rosalia'],

            // Estructuras de Datos I
            ['materia'=>'2231','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 8-9',  'salon'=>'I-LCB-3','cupo'=>30,'profesor'=>'De La Cruz Lopez Miguel Angel'],
            ['materia'=>'2231','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 18-19','salon'=>'I-LCA-1','cupo'=>30,'profesor'=>'Muniz Sandate Salvador'],
            ['materia'=>'2231','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 17-18','salon'=>'I-LCB-1','cupo'=>30,'profesor'=>'De La Cruz Lopez Miguel Angel'],
            ['materia'=>'2231','grupo'=>'4','horario'=>'Lun-Mar-Mié-Jue-Vie 18-19','salon'=>'I-LCB-3','cupo'=>30,'profesor'=>'De La Cruz Lopez Miguel Angel'],
            ['materia'=>'2231','grupo'=>'5','horario'=>'Lun-Mar-Mié-Jue-Vie 19-20','salon'=>'I-14',   'cupo'=>30,'profesor'=>'De La Cruz Lopez Miguel Angel'],
            ['materia'=>'2231','grupo'=>'6','horario'=>'Lun-Mar-Mié-Jue-Vie 9-10', 'salon'=>'I-LCB-1','cupo'=>30,'profesor'=>'Vaca Rivera Silvia Luz'],
            ['materia'=>'2231','grupo'=>'7','horario'=>'Lun-Mar-Mié-Jue-Vie 8-9',  'salon'=>'I-06',   'cupo'=>30,'profesor'=>'Muniz Sandate Salvador'],

            // Matemáticas Discretas II
            ['materia'=>'2152','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 9-10', 'salon'=>'I-04','cupo'=>30,'profesor'=>'De La Cruz Lopez Miguel Angel'],
            ['materia'=>'2152','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 17-18','salon'=>'I-11','cupo'=>30,'profesor'=>'Juarez Martinez Uriel'],
            ['materia'=>'2152','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 11-12','salon'=>'I-04','cupo'=>30,'profesor'=>'Hernandez Morales Carlos Alberto'],
            ['materia'=>'2152','grupo'=>'5','horario'=>'Lun-Mar-Mié-Jue-Vie 14-15','salon'=>'I-04','cupo'=>30,'profesor'=>'Avila Montoya Clara Rosalia'],
            ['materia'=>'2152','grupo'=>'8','horario'=>'Lun-Mar-Mié-Jue-Vie 8-9',  'salon'=>'I-03','cupo'=>30,'profesor'=>'Reyes Cardenas Oscar'],

            // Lenguajes de Programación
            ['materia'=>'2233','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 8-9',  'salon'=>'I-LCB-1','cupo'=>30,'profesor'=>'Acosta Espinoza Juan Jose'],
            ['materia'=>'2233','grupo'=>'4','horario'=>'Lun-Mar-Mié-Jue-Vie 7-8',  'salon'=>'I-LCB-1','cupo'=>30,'profesor'=>'Acosta Espinoza Juan Jose'],
            ['materia'=>'2233','grupo'=>'5','horario'=>'Lun-Mar-Mié-Jue-Vie 18-19','salon'=>'I-LCA-2','cupo'=>30,'profesor'=>'Martinez Perez Francisco Eduardo'],

            // Estructuras de Datos II
            ['materia'=>'2232','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 11-12','salon'=>'I-LCA-2','cupo'=>30,'profesor'=>'Vaca Rivera Silvia Luz'],
            ['materia'=>'2232','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 7-8',  'salon'=>'I-LCA-1','cupo'=>30,'profesor'=>'De La Cruz Lopez Miguel Angel'],
            ['materia'=>'2232','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 12-13','salon'=>'I-LCA-2','cupo'=>30,'profesor'=>'Hernandez Castro Froylan Eloy'],
            ['materia'=>'2232','grupo'=>'4','horario'=>'Lun-Mar-Mié-Jue-Vie 9-10', 'salon'=>'I-LCA-1','cupo'=>30,'profesor'=>'De La Cruz Lopez Miguel Angel'],

            // Tecnología Orientada a Objetos
            ['materia'=>'2234','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 12-13','salon'=>'I-LCB-1','cupo'=>30,'profesor'=>'Perez Gonzalez Hector Gerardo'],
            ['materia'=>'2234','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 10-11','salon'=>'I-LCB-1','cupo'=>30,'profesor'=>'Hernandez Castro Froylan Eloy'],
            ['materia'=>'2234','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 13-14','salon'=>'I-LCA-1','cupo'=>30,'profesor'=>'Nuñez Varela Alberto Salvador'],
            ['materia'=>'2234','grupo'=>'4','horario'=>'Lun-Mar-Mié-Jue-Vie 11-12','salon'=>'I-13',   'cupo'=>30,'profesor'=>'Hernandez Castro Froylan Eloy'],

            // Análisis Numérico
            ['materia'=>'2111','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 9-10', 'salon'=>'I-11','cupo'=>30,'profesor'=>'Meade Collins Jaime Federico'],
            ['materia'=>'2111','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 16-17','salon'=>'I-16','cupo'=>30,'profesor'=>'Reyes Castillo Rito'],
            ['materia'=>'2111','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 8-9',  'salon'=>'I-11','cupo'=>30,'profesor'=>'Meade Collins Jaime Federico'],

            // Probabilidad y Estadística
            ['materia'=>'2112','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 12-13','salon'=>'I-11','cupo'=>30,'profesor'=>'Meade Collins Jaime Federico'],
            ['materia'=>'2112','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 11-12','salon'=>'I-11','cupo'=>30,'profesor'=>'Meade Collins Jaime Federico'],
            ['materia'=>'2112','grupo'=>'4','horario'=>'Lun-Mar-Mié-Jue-Vie 18-19','salon'=>'I-16','cupo'=>30,'profesor'=>'Reyes Castillo Rito'],

            // Algoritmos y Complejidad
            ['materia'=>'2235','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 11-12','salon'=>'I-05',   'cupo'=>30,'profesor'=>'Nuñez Varela Alberto Salvador'],
            ['materia'=>'2235','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 9-10', 'salon'=>'L-48',   'cupo'=>30,'profesor'=>'Torres Reyes Francisco Javier'],
            ['materia'=>'2235','grupo'=>'4','horario'=>'Lun-Mar-Mié-Jue-Vie 19-20','salon'=>'I-11',   'cupo'=>30,'profesor'=>'Juarez Martinez Uriel'],

            // Interfaces Gráficas con Aplicaciones
            ['materia'=>'2236','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 10-11','salon'=>'I-LCA-1','cupo'=>30,'profesor'=>'Nuñez Varela Alberto Salvador'],
            ['materia'=>'2236','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 12-13','salon'=>'I-LCA-1','cupo'=>30,'profesor'=>'Nuñez Varela Alberto Salvador'],

            // Modelado Matemático
            ['materia'=>'2113','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 10-11','salon'=>'I-11','cupo'=>30,'profesor'=>'Meade Collins Jaime Federico'],
            ['materia'=>'2113','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 17-18','salon'=>'I-16','cupo'=>30,'profesor'=>'Reyes Castillo Rito'],

            // Sistemas Operativos
            ['materia'=>'2252','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 12-13','salon'=>'L-48','cupo'=>30,'profesor'=>'Torres Reyes Francisco Javier'],
            ['materia'=>'2252','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 18-19','salon'=>'I-15','cupo'=>30,'profesor'=>'Juarez Martinez Uriel'],
            ['materia'=>'2252','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 8-9',  'salon'=>'L-48','cupo'=>30,'profesor'=>'Torres Reyes Francisco Javier'],

            // Aplicaciones Web Interactivas
            ['materia'=>'2237','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 16-17','salon'=>'I-13','cupo'=>30,'profesor'=>'Varela Tristan Gerardo Antonio'],
            ['materia'=>'2237','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 17-18','salon'=>'I-13','cupo'=>30,'profesor'=>'Varela Tristan Gerardo Antonio'],

            // Fundamentos de Desarrollo Web
            ['materia'=>'2238','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 15-16','salon'=>'I-01','cupo'=>30,'profesor'=>'Rodriguez Sanchez Jose de Jesus'],
            ['materia'=>'2238','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 18-19','salon'=>'I-01','cupo'=>30,'profesor'=>'Gomez Vazquez Francisco Javier'],

            // Ingeniería de Software
            ['materia'=>'2304','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 7-8',  'salon'=>'I-14','cupo'=>30,'profesor'=>'Perez Gonzalez Hector Gerardo'],
            ['materia'=>'2304','grupo'=>'3','horario'=>'Lun-Mar-Mié-Jue-Vie 10-11','salon'=>'I-12','cupo'=>30,'profesor'=>'Perez Gonzalez Hector Gerardo'],
            ['materia'=>'2304','grupo'=>'4','horario'=>'Lun-Mar-Mié-Jue-Vie 11-12','salon'=>'I-12','cupo'=>30,'profesor'=>'Perez Gonzalez Hector Gerardo'],

            // Proyectos Computacionales I
            ['materia'=>'2050','grupo'=>'1','horario'=>'Lun-Mar-Jue-Vie 9-10',     'salon'=>'I-12','cupo'=>30,'profesor'=>'Nava Muñoz Sandra Edith'],
            ['materia'=>'2050','grupo'=>'2','horario'=>'Lun-Mar-Jue-Vie 18-19',    'salon'=>'I-13','cupo'=>30,'profesor'=>'Martinez Murillo Raul Antonio'],
            ['materia'=>'2050','grupo'=>'3','horario'=>'Lun-Mar-Jue-Vie 9-10',     'salon'=>'I-13','cupo'=>30,'profesor'=>'Martinez Perez Francisco Eduardo'],

            // Proyectos Computacionales II
            ['materia'=>'2051','grupo'=>'1','horario'=>'Lun-Mar-Jue-Vie 8-9',      'salon'=>'I-15','cupo'=>30,'profesor'=>'Nuñez Varela Alberto Salvador'],
            ['materia'=>'2051','grupo'=>'2','horario'=>'Lun-Mar-Jue-Vie 8-9',      'salon'=>'I-12','cupo'=>30,'profesor'=>'Nava Muñoz Sandra Edith'],
            ['materia'=>'2051','grupo'=>'3','horario'=>'Lun-Mar-Jue-Vie 8-9',      'salon'=>'I-13','cupo'=>30,'profesor'=>'Martinez Murillo Raul Antonio'],

            // Fundamentos de Desarrollo Móvil
            ['materia'=>'2239','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 8-9',  'salon'=>'I-LCA-1','cupo'=>30,'profesor'=>'Ordaz Narvaez Oscar Alejandro'],
            ['materia'=>'2239','grupo'=>'2','horario'=>'Lun-Mar-Mié-Jue-Vie 19-20','salon'=>'I-LCA-2','cupo'=>30,'profesor'=>'Ordaz Narvaez Oscar Alejandro'],

            // Seminario de Medio Término
            ['materia'=>'2008','grupo'=>'1','horario'=>'Jue 18-20','salon'=>'L-AUD','cupo'=>60,'profesor'=>'Martinez Perez Francisco Eduardo'],
            ['materia'=>'2008','grupo'=>'2','horario'=>'Jue 18-20','salon'=>'L-AUD','cupo'=>60,'profesor'=>'Martinez Murillo Raul Antonio'],

            // Computación y Sociedad
            ['materia'=>'2085','grupo'=>'1','horario'=>'Mié 18-20','salon'=>'E-AM', 'cupo'=>60,'profesor'=>'Vaca Rivera Silvia Luz'],

            // Supercomputo
            ['materia'=>'2228','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 11-12','salon'=>'H-LRT-1','cupo'=>30,'profesor'=>'Vaca Rivera Silvia Luz'],

            // Estructuras de Datos Avanzadas
            ['materia'=>'2206','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 18-19','salon'=>'I-11','cupo'=>30,'profesor'=>'Juarez Martinez Uriel'],

            // Diseño de Interfaces
            ['materia'=>'2244','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 17-18','salon'=>'I-14','cupo'=>30,'profesor'=>'Vaca Rivera Silvia Luz'],

            // Aplicaciones Web Escalables
            ['materia'=>'2245','grupo'=>'1','horario'=>'Lun-Mar-Mié-Jue-Vie 19-20','salon'=>'I-01','cupo'=>30,'profesor'=>'Gomez Vazquez Francisco Javier'],

            // Administración de Proyectos I
            ['materia'=>'2053','grupo'=>'2','horario'=>'Lun-Mar-Jue-Vie 18-19',    'salon'=>'I-12','cupo'=>30,'profesor'=>'Martinez Perez Francisco Eduardo'],
            ['materia'=>'2053','grupo'=>'3','horario'=>'Lun-Mar-Jue-Vie 8-9',      'salon'=>'I-14','cupo'=>30,'profesor'=>'Perez Gonzalez Hector Gerardo'],
            ['materia'=>'2053','grupo'=>'4','horario'=>'Lun-Mar-Jue-Vie 18-19',    'salon'=>'I-06','cupo'=>30,'profesor'=>'Juarez Martinez Uriel'],

            // Administración de Proyectos II
            ['materia'=>'2054','grupo'=>'1','horario'=>'Lun-Mar-Jue-Vie 14-15',    'salon'=>'I-15','cupo'=>30,'profesor'=>'Vaca Rivera Silvia Luz'],
            ['materia'=>'2054','grupo'=>'2','horario'=>'Lun-Mar-Jue-Vie 8-9',      'salon'=>'I-05','cupo'=>30,'profesor'=>'Juarez Martinez Uriel'],
        ];

        foreach ($grupos as $g) {
            $materia = $materias[$g['materia']] ?? null;
            
            if (!$materia) continue;

            $profesorId = $profesorIds[$g['profesor']] ?? null;

            Grupo::create([
                'materia_id'   => $materia->id,
                'profesor_id'  => $profesorId,
                'nombre_grupo' => 'Grupo ' . $g['grupo'],
                'horario'      => $g['horario'],
                'modalidad'    => 'Presencial',
                'cupo'         => $g['cupo'],
                'salon'        => $g['salon'],
            ]);
        }
    }
}