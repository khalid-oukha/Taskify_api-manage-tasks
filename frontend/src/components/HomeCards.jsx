import React from 'react'
import Card from './Card'
export default function HomeCards() {
    return (
        <>
            <section className="py-4">
                <div className="container-xl lg:container m-auto">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-lg">
                        <div className="bg-gray-100 p-6 rounded-lg shadow-md">
                            <Card>
                                <h2 className="text-2xl font-bold">For Developers</h2>
                                <p className="mt-2 mb-4">
                                    Find React jobs that match your skills and expertise
                                </p>
                                <a
                                    href="/jobs.html"
                                    className="inline-block bg-indigo-500 text-white rounded-lg px-4 py-2 hover:bg-indigo-600"
                                >
                                    Browse Jobs
                                </a>
                            </Card>
                        </div>
                        <div className="bg-indigo-100 p-6 rounded-lg shadow-md">
                            <Card>
                            <h2 className="text-2xl font-bold">For Employers</h2>
                            <p className="mt-2 mb-4">
                                List your job to find the perfect developer for the role
                            </p>
                            <a
                                href="/add-job.html"
                                className="inline-block bg-indigo-500 text-white rounded-lg px-4 py-2 hover:bg-indigo-600"
                            >
                                Add Job
                            </a>
                            </Card>

                        </div>
                    </div>
                </div>
            </section>

        </>
    )
}
