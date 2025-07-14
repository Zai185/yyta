export type Course = {
    id: number,
    name: string,
    description: string,
    img_url?: string,
    duration: number,
    fee: number,
    is_online: boolean
    modules: Module[]
}

export type Module = {
    id: number,
    name: string,
    credits: number,
    course_id: number,
}