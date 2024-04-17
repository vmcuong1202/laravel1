import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
// import { USER_STATUS_CLASS_MAP, USER_STATUS_TEXT_MAP } from "@/constant.jsx";
export default function Show({ auth, user }) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {`User "${user.data.name}"`}
        </h2>
      }
    >
      <Head title={`User "${user.data.name}"`} />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div>
              <img
                src={user.image_path}
                alt=""
                className="w-full h-64 object-cover"
              />
            </div>
            <div className="p-6 text-gray-900 dark:text-gray-100">
              <div className="grid gap-1 grid-cols-2 mt-2">
                <div>
                  <div>
                    <label className="font-bold text-lg">User ID</label>
                    <p className="mt-1">{user.data.id}</p>
                  </div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">User Name</label>
                    <p className="mt-1">{user.data.name}</p>
                  </div>
                </div>
              </div>
              <div className="mt-4">
                <label className="font-bold text-lg">User Email</label>
                <p className="mt-1">{user.data.email}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
