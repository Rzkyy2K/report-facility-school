export type UserRole =
    | 'siswa'
    | 'guru'
    | 'sarana'
    | 'kepala_sekolah'
    | 'teknisi';

export type User = {
    id: number;
    nama_lengkap: string;
    nomor_induk: string | null;
    email: string;
    role: UserRole;
    no_telepon: string | null;
    avatar?: string;
    created_at: string | null;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};

export type Passkey = {
    id: number;
    name: string;
    authenticator: string | null;
    created_at_diff: string;
    last_used_at_diff: string | null;
};

export type TwoFactorSetupData = {
    svg: string;
    url: string;
};

export type TwoFactorSecretKey = {
    secretKey: string;
};
