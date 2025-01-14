import InfoButton from "@/Components/Button/InfoButton";
import WarningButton from "@/Components/Button/WarningButton";
import { AlertMessage } from "@/Components/Delete/AlertMessage/AlertMessage";
import { ConfirmDelete } from "@/Components/Delete/ConfirmDelete";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, usePage } from "@inertiajs/react";

export default function UserShow({ auth, user }) {
    const { flash } = usePage().props;

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Users
                </h2>
            }
        >
            <Head title="users" />

            <div className="py-4 max-w-7xl max-auto sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-lg sm:rounded-lg dark:bg-gray-800">
                    <div className="flex justify-between items-center m-4 text-white">
                        <h3 className="text-lg">View</h3>
                        <div className="flex space-x-1">
                            <Link href={route("users.index")}>
                                <InfoButton className="text-sm">
                                    List
                                </InfoButton>
                            </Link>
                            <Link href={route("users.edit", { user: user.id })}>
                                <WarningButton className="text-sm">
                                    Edit
                                </WarningButton>
                            </Link>
                            <ConfirmDelete id={user.id} routeName="users.destroy" />
                        </div>
                    </div>

                    <AlertMessage message={flash}/>

                    <div className="bg-white text-sm dark:bg-gray-800 p-4 shadow-md">
                        <div className="mb-4">
                            <p className="text-md font-semibold text-gray-400 dark:text-gray-200">
                                ID
                            </p>
                            <p className="text-gray-600 dark:text-gray-400">
                                {user.id}
                            </p>
                        </div>
                        <div className="mb-4">
                            <p className="text-md font-semibold text-gray-400 dark:text-gray-200">
                                Name
                            </p>
                            <p className="text-gray-600 dark:text-gray-400">
                                {user.name}
                            </p>
                        </div>
                        <div className="mb-4">
                            <p className="text-md font-semibold text-gray-400 dark:text-gray-200">
                                Email
                            </p>
                            <p className="text-gray-600 dark:text-gray-400">
                                {user.email}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
