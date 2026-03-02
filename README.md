****** tinker diye 1st super admin set code is here***********


use App\Models\User;
use Spatie\Permission\Models\Role;

// Super Admin Role তৈরি করুন
Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

// User তৈরি করুন (আপনার ইচ্ছামত email/password দিন)
 $user = User::create([
    'name' => 'Super Admin',
    'email' => 'susmita.dch@gmail.com 
    'password' => bcrypt('susmita@123')
]);

// Super Admin role assign করুন
 $user->assignRole('super-admin');

// যাচাই করুন
 $user->hasRole('super-admin');


 ********  Tinker diye pass o email change korte caile ai command  ******
 
 use App\Models\User;

 $user = User::first();
 $user->email = 'susmita.dch@gmail.com';
 $user->password = bcrypt  ('susmita@123');
 $user->save();



***last vabe aita diye super admin pass set korechi***


use App\Models\User;

User::create([
    'name' => 'Admin',
    'email' => 'susmita.dch@gmail.com',
    'password' => bcrypt('susmita@123')
])->assignRole('super-admin');




use App\Models\User;

User::create([
    'name' => 'Admin',
    'email' => 'susmita.dch@gmail.com',
    'password' => bcrypt('susmita@123')
])->assignRole('super-admin');



GLM theke sudhu role index file er css class soho blade file copy kore boshiyechi.