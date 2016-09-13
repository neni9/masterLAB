<?php

use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Post::class, function (Faker\Generator $faker) {

	$titlePost = 
	[
	    "La machine de Turin",
	    "Les suites numériques",
	    "Javascript",
	    "Division par zéro",
	    "Le nombre d'or",
	    "Les Palindromes",
	    "Les suites géométriques",
	    "Le nombre Pi",
	    "Jeux d'argent et statistiques : Serez-vous le prochain gagnant?",
	    "Le théorème d'Euler",
	    "Pile ou Face",
	    "Prix Abel 2016",
	    "Portrait du jour : Archimède",
	    "Portrait du jour :Aristote",
	    "Portrait du jour : Newton",
	    "La suite de Fibonacci",
	    "Portrait du jour : Euclide",
	    "Le pari de Pascal",
	    "La conjecture de Syracuse",
	    "Identités remarquables",
	    "L'infini",
	    "Le nombre e",
	    "Les nombres premiers",
	    "Les nombres parfaits",
	    "Le zéro",
	    "Les aiguilles de Buffon",
	    "Topologie",
	    "Théorie des ensembles",
	    "Théroème de Pythagore",
	    "Algèbre",
	    "Problème des sept ponts de Königsberg",
	    "Probabilités",
	    "Paradoxe de Banach-Tarski",
	    "Paradoxe d'Achille et de la tortue",
	    "Paradoxe du carré manquant",
	    "Enigme du dollar manquant",
	    "Méthode Condorcet",
	    "Pradoxe de Cramer",
	    "Séminaire sur l'enseignement des Mathématiques",
	    "Théorème des contenus",
	    "Théorème d'Euclide",
	    "Les modulos",
	    "Théroème de Gauss",
	];

	$status = ['published','unpublished'];

    $fakePosts = 
    [
        'title' => $titlePost[array_rand($titlePost)],
        'excerpt' => $faker->text(255),
        'content' =>"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Si stante, hoc natura videlicet vult, salvam esse se, quod concedimus; <a href='http://loripsum.net/' target='_blank'>Iam id ipsum absurdum, maximum malum neglegi.</a> Quod quidem iam fit etiam in Academia. In contemplatione et cognitione posita rerum, quae quia deorum erat vitae simillima, sapiente visa est dignissima. Quia nec honesto quic quam honestius nec turpi turpius. Duo Reges: constructio interrete. Nec vero intermittunt aut admirationem earum rerum, quae sunt ab antiquis repertae, aut investigationem novarum. </p>

<blockquote cite='http://loripsum.net'>
	Primum enim, si vera sunt ea, quorum recordatione te gaudere dicis, hoc est, si vera sunt tua scripta et inventa, gaudere non potes.
</blockquote>


<p>Atque haec coniunctio confusioque virtutum tamen a philosophis ratione quadam distinguitur. Recte dicis; Bonum negas esse divitias, praeposìtum esse dicis? <a href='http://loripsum.net/' target='_blank'>Sed ad bona praeterita redeamus.</a> Cur deinde Metrodori liberos commendas? Qui ita affectus, beatum esse numquam probabis; </p>

<ul>
	<li>Tu autem negas fortem esse quemquam posse, qui dolorem malum putet.</li>
	<li>Nec lapathi suavitatem acupenseri Galloni Laelius anteponebat, sed suavitatem ipsam neglegebat;</li>
	<li>Equidem etiam Epicurum, in physicis quidem, Democriteum puto.</li>
	<li>Qualis ista philosophia est, quae non interitum afferat pravitatis, sed sit contenta mediocritate vitiorum?</li>
	<li>At, illa, ut vobis placet, partem quandam tuetur, reliquam deserit.</li>
	<li>Facile est hoc cernere in primis puerorum aetatulis.</li>
</ul>


<p>Facete M. Ergo ita: non posse honeste vivi, nisi honeste vivatur? <i>Ille incendat?</i> <a href='http://loripsum.net/' target='_blank'>Quamquam tu hanc copiosiorem etiam soles dicere.</a> Isto modo ne improbos quidem, si essent boni viri. <b>At iam decimum annum in spelunca iacet.</b> </p>

<p>Quis tibi ergo istud dabit praeter Pyrrhonem, Aristonem eorumve similes, quos tu non probas? Aufert enim sensus actionemque tollit omnem. <a href='http://loripsum.net/' target='_blank'>Quam nemo umquam voluptatem appellavit, appellat;</a> Quarum ambarum rerum cum medicinam pollicetur, luxuriae licentiam pollicetur. <mark>Quod ea non occurrentia fingunt, vincunt Aristonem;</mark> Minime vero, inquit ille, consentit. </p>

<p>Est enim effectrix multarum et magnarum voluptatum. Qui-vere falsone, quaerere mittimus-dicitur oculis se privasse; Haec quo modo conveniant, non sane intellego. Quid enim de amicitia statueris utilitatis causa expetenda vides. Quae quo sunt excelsiores, eo dant clariora indicia naturae. Scaevola tribunus plebis ferret ad plebem vellentne de ea re quaeri. Nunc haec primum fortasse audientis servire debemus. Habent enim et bene longam et satis litigiosam disputationem. </p>

",
        'user_id' => rand(1, 3),
        'status' => $status[array_rand($status)],
        'published_at' => $faker->dateTimeBetween("2015-01-01 00:00:00","2016-07-31 00:00:00")->format('Y-m-d H:i:s'), 
        'user_id' => rand(1,3)
    ];

    if($fakePosts['status'] == 'unpublished') $fakePosts['published_at'] = NULL;

    return $fakePosts;
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {

	$typeComment = ['valid','spam','unchecked'];

    return [
        'pseudo'  => $faker->lastName,
        'title'   => $faker->sentence,
        'content' => $faker->paragraph,
        'type'    => $typeComment[array_rand($typeComment)],
        'post_id' => rand(1,50),
        'user_id' => NULL,
        'created_at' => $faker->dateTimeBetween("2015-01-01 00:00:00","2016-07-31 00:00:00")->format('Y-m-d H:i:s')
    ];
});


