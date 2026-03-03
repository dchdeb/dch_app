****** tinker diye 1st super admin set code is here***********


use App\Models\User;
use Spatie\Permission\Models\Role;

User::create([
    'name' => 'Admin',
    'email' => 'susmita.dch@gmail.com',
    'password' => bcrypt('susmita@123')
])->assignRole('super-admin');



GLM theke sudhu role index file er css class soho blade file copy kore boshiyechi.