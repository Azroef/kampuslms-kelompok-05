    <x-layout title="Dashboard">

        <div class="w-full px-6 lg:px-8 py-6">

            <div class="flex flex-col gap-6">

                <section
                    class="relative
                        rounded-2xl
                        overflow-hidden
                        bg-gradient-to-br
                        from-[#4648d4]
                        via-[#6063ee]
                        to-[#6b38d4]
                        p-8
                        text-white
                        shadow-lg"
                >

                    <div class="relative z-10">

                        <span
                            class="inline-flex items-center gap-2
                                px-3 py-1
                                rounded-full
                                bg-white/15
                                text-[11px]
                                uppercase
                                tracking-wider"
                        >

                            <span class="material-symbols-outlined text-[16px]">
                                verified
                            </span>

                            Portal Akademik

                        </span>


                        <h1
                            class="text-3xl
                                font-bold
                                tracking-tight
                                mt-4"
                        >
                            Selamat Datang di EduKampus
                        </h1>


                        <p
                            class="text-[#e1e0ff]
                                mt-2
                                max-w-2xl"
                        >
                            Kelola informasi akademik dan eksplorasi mata kuliah
                            pada semester aktif.
                        </p>

                    </div>

                </section>

                <div
                    class="grid grid-cols-1
                        md:grid-cols-3
                        gap-4"
                >

                    <div
                        class="bg-white
                            rounded-xl
                            p-5
                            shadow-sm"
                    >

                        <span
                            class="material-symbols-outlined
                                text-[#4648d4]"
                        >
                            menu_book
                        </span>

                        <p class="text-sm text-[#464554] mt-3">
                            Mata Kuliah
                        </p>

                        <p class="text-2xl font-bold mt-1">
                            9
                        </p>

                    </div>


                    <div
                        class="bg-white
                            rounded-xl
                            p-5
                            shadow-sm"
                    >

                        <span
                            class="material-symbols-outlined
                                text-[#6b38d4]"
                        >
                            school
                        </span>

                        <p class="text-sm text-[#464554] mt-3">
                            Semester
                        </p>

                        <p class="text-2xl font-bold mt-1">
                            5
                        </p>

                    </div>


                    <div
                        class="bg-white
                            rounded-xl
                            p-5
                            shadow-sm"
                    >

                        <span
                            class="material-symbols-outlined
                                text-[#00628d]"
                        >
                            assignment
                        </span>

                        <p class="text-sm text-[#464554] mt-3">
                            Total SKS
                        </p>

                        <p class="text-2xl font-bold mt-1">
                            24
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </x-layout>